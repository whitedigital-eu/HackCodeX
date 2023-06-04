<?php declare(strict_types = 1);

namespace App\Command;

use App\Entity\School;
use App\Entity\Transport;
use App\Entity\TransportStop;
use App\Enums\TransportTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function fgetcsv;
use function fopen;
use function str_replace;
use function str_starts_with;

#[AsCommand(
    name: 'app:transport',
    description: 'Find closest transports for schools',
)]
class TransportCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schools = $this->em->getRepository(School::class)->findAll();
        if (($handle = fopen('/var/www/html/api/resources/transport/stops.txt', 'rb+')) !== false) {
            $i = -1;
            while (($data = fgetcsv($handle, 1000)) !== false) {
                $i++;
                if ($i > 0) {
                    foreach ($schools as $school) {
                        if (null !== $data[4] && null !== $data[5] && $school->getLat() && $school->getLon()) {
                            if (0.5 > $this->getDistance($school->getLat(), $school->getLon(), (float) $data[4], (float) $data[5])) {
                                $transport = $this->em->getRepository(TransportStop::class)->findOneBy(['stopId' => $data[0], 'school' => $school]);
                                if (null === $transport) {
                                    $transport = (new TransportStop())
                                        ->setSchool($school)
                                        ->setStopId($data[0]);

                                    $this->em->persist($transport);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->em->flush();

        $trips = [];
        if (($handle = fopen('/var/www/html/api/resources/transport/stop_times.txt', 'rb+')) !== false) {
            $i = -1;
            while (($data = fgetcsv($handle, 1000)) !== false) {
                $i++;
                if ($i > 0) {
                    $trips[(string) $data[0]][] = $data[3];
                }
            }
        }

        if (($handle = fopen('/var/www/html/api/resources/transport/trips.txt', 'rb+')) !== false) {
            $i = -1;
            while (($data = fgetcsv($handle, 1000)) !== false) {
                $i++;
                if ($i > 0) {
                    $type = $number = null;

                    if (str_starts_with($data[0], 'riga_bus_')) {
                        $type = TransportTypeEnum::BUS;
                        $number = str_replace('riga_bus_', '', $data[0]);
                    }

                    if (str_starts_with($data[0], 'riga_tram_')) {
                        $type = TransportTypeEnum::TRAM;
                        $number = str_replace('riga_tram_', '', $data[0]);
                    }

                    if (str_starts_with($data[0], 'riga_trol_')) {
                        $type = TransportTypeEnum::TROL;
                        $number = str_replace('riga_trol_', '', $data[0]);
                    }

                    foreach ($trips[$data[2]] as $stopId) {
                        $stop = $this->em->getRepository(TransportStop::class)->findOneBy(['stopId' => $stopId]);
                        if (null !== $stop) {
                            $transport = $this->em->getRepository(Transport::class)->findOneBy(['type' => $type, 'number' => $number, 'school' => $stop->getSchool()]);
                            if (null === $transport) {
                                $transport = (new Transport())
                                    ->setSchool($stop->getSchool())
                                    ->setType($type)
                                    ->setNumber($number);
                                $this->em->persist($transport);
                                $this->em->flush();
                            }
                        }
                    }
                    $this->em->flush();
                }
            }
        }

        $this->em->flush();

        return Command::SUCCESS;
    }

    private function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));

        return $earth_radius * $c;
    }
}
