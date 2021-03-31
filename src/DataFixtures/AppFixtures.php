<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager)
    {
        $conferences = [
            'amsterdam' => [
                'city' => 'Amsterdam',
                'year' => '2019',
                'isInternational' => true,
                'comments' => []
            ],
            'london' => [
                'city' => 'London',
                'year' => '2020',
                'isInternational' => false,
                'comments' => [
                    [
                        'author' => 'John Black',
                        'email' => 'black_johnny@gmail.com',
                        'text' => 'Hi! Thank you!'
                    ],
                    [
                        'author' => 'John Johnson',
                        'email' => 'johnson@yahoo.com',
                        'text' => 'Conference was very interesting. Organization is in high level.'
                    ]
                ]
            ],
            'paris' => [
                'city' => 'Paris',
                'year' => '2021',
                'isInternational' => true,
                'comments' => [
                    [
                        'author' => 'Bob Schneider',
                        'email' => 'crazybob1990@gmail.com',
                        'text' => 'Such a lot of interesting people in one place. It is amazing! Thanks organizators!'
                    ],
                    [
                        'author' => 'Paul Paulsen',
                        'email' => 'paulsen@gmail.com',
                        'text' => 'Thank you very much.'
                    ],
                    [
                        'author' => 'Igor Shilov',
                        'email' => 'shilovigor@yandex.ru',
                        'text' => 'I am glad to be a part of this event.'
                    ]
                ]
            ],
        ];

        foreach ($conferences as $name => $conference) {
            $newConference = new Conference();
            $newConference->setCity($conference['city']);
            $newConference->setYear($conference['year']);;
            $newConference->setIsInternational($conference['isInternational']);
            $manager->persist($newConference);
            if (!empty($conference['comments'])) {
                foreach ($conference['comments'] as $comment) {
                    $newComment = new Comment();
                    $newComment->setConference($newConference);
                    $newComment->setAuthor($comment['author']);
                    $newComment->setEmail($comment['email']);
                    $newComment->setText($comment['text']);
                    $manager->persist($newComment);
                }
            }
        }
        
        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));
        $manager->persist($admin);

        $manager->flush();
    }
}
