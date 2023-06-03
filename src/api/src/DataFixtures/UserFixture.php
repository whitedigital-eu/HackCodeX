<?php declare(strict_types = 1);

namespace App\DataFixtures;

use App\Constants\Enum\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends AbstractFixture implements FixtureGroupInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $emails = [
            'hack@whitedigital.eu' => ['roles' => [Role::ROLE_ADMIN->value, ], ],
        ];

        $i = 0;
        foreach ($emails as $email => $data) {
            $fixture = new User();
            $fixture
                ->setEmail($email)
                ->setPassword($this->userPasswordHasher->hashPassword($fixture, $data['password'] ?? 'parole'))
                ->setRoles($data['roles'])
                ->setIsActive(true);

            $manager->persist($fixture);
            $manager->flush();

            $this->addReference('user' . $i, $fixture);
            self::$references[self::class][] = 'user' . $i;
            $i++;
        }
    }

    public static function getGroups(): array
    {
        return [
            'user',
        ];
    }
}
