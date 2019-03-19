<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as FOSRest;

    /**
     * @Route("/api/commande", name="commande")
     */
class CommandeController extends AbstractController
{
    /**
     * @Route("/home", name="commande")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CommandeController.php',
        ]);
    }

    /**
     * Lists all commande.
     * @FOSRest\Get("/commandes")
     *
     * @return array
     */
    public function getCommandeAction()
    {
        $repository = $this->getDoctrine()->getRepository(Commande::class);

        // query for a single Product by its primary key (usually "id")
        $commande = $repository->findall();
        // return new Response([ $article]);
        // return Response::json($article);
        /// $json = $this->serialize($article);
        // return new JsonResponse(array('data' => $article));

        $response = new Response(json_encode($commande));

        return $response;

        // return View::create($article, Response::HTTP_OK , []);
    }

    /**
     * Create Commande.
     * @FOSRest\Post("/add")
     *
     * @return array
     */
    public function postCommandeAction(Request $request)
    {
        $commande = new Commande();
        $commande->setRef($request->get('ref'));
        $commande->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($commande);
        $em->flush();
        //  return View::create($article, Response::HTTP_CREATED , []);
        //return new Response(['data'=> "okkk"]);
        $response = new Response(json_encode($commande));

        return $response;

    }

    /**
     * Edit Commande.
     * @FOSRest\Post("/edit/{id}")
     *
     * @return array
     */
    public function editCommandeAction(Request $request , $id)
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);


        $commande->setRef($request->get('ref'));
        $commande->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        //  return View::create($article, Response::HTTP_CREATED , []);
        //return new Response(['data'=> "okkk"]);
        $response = new Response(json_encode($commande));

        return $response;

    }
    /**
     * Delete Commande.
     * @FOSRest\Post("/delete/{id}")
     *
     * @return array
     */
    public function deleteCommandeAction(Request $request , $id)
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();

        $response = new Response(json_encode($commande));
        $response->send();
        return $response;


    }
}
