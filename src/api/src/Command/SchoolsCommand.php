<?php declare(strict_types = 1);

namespace App\Command;

use App\Entity\School;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

use function json_decode;
use function str_replace;

#[AsCommand(
    name: 'app:schools',
    description: 'import school address',
)]
class SchoolsCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schools = $this->em->getRepository(School::class)->findAll();
        foreach ($schools as $school) {
            if (null === $school->getAddress()) {
                $title = str_replace(' ', '+', str_replace('"', ' ', $school->getTitle()));
                $request = HttpClient::create()->request(Request::METHOD_GET, 'https://nominatim.openstreetmap.org/search?amenity=' . $title . '&format=json&addressdetails=1');
                if ([] !== ($data = json_decode($request->getContent(false), true))) {
                    $address = $data[0]['address']['road'] ?? null;
                    if (null !== $address) {
                        if (null !== ($number = $data[0]['address']['house_number'] ?? null)) {
                            $address .= ', ' . $number;
                        }

                        $school->setAddress($address);
                        $school->setLat((float) $data[0]['lat']);
                        $school->setLon((float) $data[0]['lon']);
                        $this->em->persist($school);
                    }
                }
            }
        }
        $this->em->flush();

        return Command::SUCCESS;
    }
}
