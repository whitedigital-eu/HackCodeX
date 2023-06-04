<?php declare(strict_types = 1);

namespace App\Command;

use App\Repository\RespondentRepository;
use App\Service\OpenAIService;
use Exception;
use Random\Randomizer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'generate-quiz-images', description: 'Add a short description for your command', )]
class GenerateQuizImagesCommand extends Command
{
    protected OpenAIService $openAiService;

    public function __construct(OpenAIService $openAiService, ?string $name = null)
    {
        parent::__construct($name);
        $this->openAiService = $openAiService;
    }

    protected function configure(): void
    {
        $this->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $randomizer = (new Randomizer());
        $quizData = [];
        $io = new SymfonyStyle($input, $output);
        for ($i = 0; $i < 100; $i++) {
            $choices = [];
            for ($j = 0; $j < 2; $j++) {
                $count = $randomizer->getInt(1, 3);
                $characteristics = [];
                while (count($characteristics) < $count) {
                    $characteristics[] = RespondentRepository::ATTRS[$randomizer->getInt(0, count(RespondentRepository::ATTRS) - 1)];
                    $characteristics = array_values(array_unique($characteristics));
                }
                $io->info('Selected characteristics are: ' . implode(', ', $characteristics));
                $prompt = $this->openAiService->generateImageGenerationPromptBasedOnCharacteristics($characteristics);
                $io->info("Image generation prompt is: $prompt");
                $url = $this->openAiService->generateImageBasedOnPrompt($prompt);
                $io->success($url);
                $file = file_get_contents($url);
                $filePath = '/quiz-images/' . $randomizer->shuffleBytes('qwertyuiopasdfghjkl') . '.png';
                file_put_contents("/var/www/html/api/public$filePath", $file);
                $quizChars = [];
                foreach ($characteristics as $characteristic) {
                    $quizChars[$characteristic] = 1;
                }
                $choices[] = [
                    'image' => $filePath,
                    'attributes' => $quizChars,
                ];
            }
            $quizData[] = [
                'choices' => $choices,
            ];
        }
        file_put_contents('/var/www/html/api/public/quiz-images/image-data.json',
            json_encode($quizData, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES));

        return Command::SUCCESS;
    }
}
