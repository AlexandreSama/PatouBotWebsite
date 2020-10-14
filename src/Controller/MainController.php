<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="Accueil")
     */
    public function index()
    {

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'http://185.216.25.216/message.json');

        $content = $response->getContent();

        $serverCount = json_decode($content, true);

        $products = $this->getDoctrine()
        ->getRepository(Users::class)
        ->getAllUsers();

        $commands = $this->getDoctrine()
        ->getRepository(Command::class)
        ->getAllCommands();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'products' => $products,
            'serverCount' => $serverCount,
            'commands' => $commands
        ]);
    }
}
