<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Article;

/**
 * @Route("/api/articles", name="article")
 */
class ArticleController extends AbstractController
{
    /**
     * Lists all Articles.
     * @FOSRest\Get("/articles")
     *
     * @return array
     */
    public function getArticleAction()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        // query for a single Product by its primary key (usually "id")
        $article = $repository->findall();
       // return new Response([ $article]);
       // return Response::json($article);
       /// $json = $this->serialize($article);
       // return new JsonResponse(array('data' => $article));

        $response = new Response(json_encode($article));

        return $response;

        // return View::create($article, Response::HTTP_OK , []);
    }

    /**
     * Create Article.
     * @FOSRest\Post("/add")
     *
     * @return array
     */
    public function postArticleAction(Request $request)
    {


        $article = new Article();
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($request->get('idCat'));
        $article->setName($request->get('name'));
        $article->setDescription($request->get('description'));
        $article->setCategorie($categorie);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
      //  return View::create($article, Response::HTTP_CREATED , []);
        //return new Response(['data'=> "okkk"]);
        $response = new Response(json_encode($article));

        return $response;
        
    }

    /**
     * Edit Article.
     * @FOSRest\Post("/article/edit/{id}")
     *
     * @return array
     */
    public function editArticleAction(Request $request , $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);


        $article->setName($request->get('name'));
        $article->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        //  return View::create($article, Response::HTTP_CREATED , []);
        //return new Response(['data'=> "okkk"]);
        $response = new Response(json_encode($article));

        return $response;

    }

    /**
     * Delete Article.
     * @FOSRest\Post("/article/delete/{id}")
     *
     * @return array
     */
    public function deleteArticleAction(Request $request , $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        $response = new Response(json_encode($article));
        $response->send();
        return $response;


    }
}
