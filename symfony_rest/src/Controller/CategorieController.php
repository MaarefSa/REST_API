<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Article;
use App\Entity\Categorie;

/**
 * @Route("/api/categories", name="categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/home", name="categorie")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CategorieController.php',
        ]);
    }
    /**
     * Lists all Categories.
     * @FOSRest\Get("/categories")
     *
     * @return array
     */
    public function getCategorieAction()
    {
        $repository = $this->getDoctrine()->getRepository(Categorie::class);

        // query for a single Product by its primary key (usually "id")
        $categorie = $repository->findall();
        // return new Response([ $article]);
        // return Response::json($article);
        /// $json = $this->serialize($article);
        // return new JsonResponse(array('data' => $article));

        $response = new Response(json_encode($categorie));

        return $response;

        // return View::create($article, Response::HTTP_OK , []);
    }

    /**
     * Create Categories.
     * @FOSRest\Post("/categorie")
     *
     * @return array
     */
    public function postCategorieAction(Request $request)
    {
        $categorie = new Categorie();
        $categorie->setName($request->get('name'));
        $categorie->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->flush();
        //  return View::create($article, Response::HTTP_CREATED , []);
        //return new Response(['data'=> "okkk"]);
        $response = new Response(json_encode($categorie));

        return $response;

    }

    /**
     * Edit Categories.
     * @FOSRest\Post("/categorie/edit/{id}")
     *
     * @return array
     */
    public function editArticleAction(Request $request , $id)
    {
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);


        $categorie->setName($request->get('name'));
        $categorie->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        //  return View::create($article, Response::HTTP_CREATED , []);
        //return new Response(['data'=> "okkk"]);
        $response = new Response(json_encode($categorie));

        return $response;

    }

    /**
     * Delete Categories.
     * @FOSRest\Post("/categorie/delete/{id}")
     *
     * @return array
     */
    public function deleteArticleAction(Request $request , $id)
    {
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        $response = new Response(json_encode($categorie));
        $response->send();
        return $response;


    }

}
