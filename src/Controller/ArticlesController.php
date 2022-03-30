<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Media;
use App\Form\AddArticleType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function viewArticle(ArticlesRepository $articlesRepository): Response
    {
        $articleContent = $articlesRepository->findAll();


        return $this->render('blog/index.html.twig', [
            'controller_name' => 'ArticlesController',
            'articles' => $articleContent
        ]);
    }

    #[Route('/addBlog', name: 'addBlog', methods: ['GET','POST'])]
    public function addArticle(ArticlesRepository $articlesRepository, Request $request, EntityManagerInterface $entityManager){
        $article = new Articles();
        $media = new Media();

       $form = $this->createForm(AddArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()). '.' . $file->guessExtension();
            $file->move($this->getParameter('uploadDirectory'),$fileName);
            $media->setName($fileName);
            $article->setImage($media);
            $articlesRepository->add($article);
            $entityManager->persist($article);
            $entityManager->flush();
        }
        return $this->render('blog/add.html.twig', ['addForm'  => $form->createView()]);
    }

}
