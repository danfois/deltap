<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Category;
use AppBundle\Form\CreateCategoryType;
use AppBundle\Util\TableMaker;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{

    //TODO: AGGIUNGERE CRUD

    /**
     * @Route("create-category", name="create_category")
     */
    public function createCategoryAction()
    {
        $category = new Category();
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $form = $this->createForm(CreateCategoryType::class, $category);

        return $this->render('categories/create_category.html.twig', array(
            'form' => $form->createView(),
            'categories' => $categories
        ));
    }

    /**
     * @Route("create-category-ajax", name="create_category_ajax")
     */
    public function createCategoryAjaxAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CreateCategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $category = $form->getData();

            $em->persist($category);
            $em->flush();

            return new Response($this->generateUrl('generate_category_table'), 200);
        }
        return new Response('Error', 500);
    }

    /**
     * @Route("generate-category-table", name="generate_category_table")
     */
    public function generateCategoryTableAction()
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $TableMaker = new TableMaker(TableMaker::DEFAULT_TABLE, $categories, array(
            'Id' => 'category_id',
            'Nome Categoria' => 'category_name'
        ));

        $table = $TableMaker->createTable()->getTable();

        return new Response($table, 200);
    }

}