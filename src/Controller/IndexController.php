<?php
namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Entity\Article ; 
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\CategorySearch;
use App\Form\CategorySearchType;

class IndexController extends AbstractController
{

    /**
 *@Route("/",name="article_list")
 */
 public function home()
 
 {
   //récupérer tous les articles de la table article de la BD
   // et les mettre dans le tableau $articles
  $articles= $this->getDoctrine()->getRepository(Article::class)->findAll();
  return $this->render('articles/index.html.twig',['articles'=> $articles]); 
    }
   
    /**
    * @Route("/article/new", name="new_article")
    * Method({"GET", "POST"})
    */
    public function new(Request $request) {
      $article = new Article();
      $form = $this->createForm(ArticleType::class,$article);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
      $article = $form->getData();
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($article);
      $entityManager->flush();
      return $this->redirectToRoute('article_list');
      }
      return $this->render('articles/new.html.twig',['form' => $form->createView()]);
    }

    /**
 * @Route("/article/{id}", name="article_show")
 */
    public function show($id) {
    $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
    return $this->render('articles/show.html.twig',
     array('article' => $article));
     }

     /**
     * @Route("/article/edit/{id}", name="edit_article")
     * Method({"GET", "POST"})
     */
     public function edit(Request $request, $id) {
     $article = new Article();
     $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
     
     $form = $this->createFormBuilder($article)
     ->add('nom', TextType::class)
     ->add('prix', TextType::class)
     ->add('image', TextType::class)
     ->add('save', SubmitType::class, array(
     'label' => 'Modifier' 
     ))->getForm();
     
     $form->handleRequest($request);
     if($form->isSubmitted() && $form->isValid()) {
     
     $entityManager = $this->getDoctrine()->getManager();
     $entityManager->flush();
     
     return $this->redirectToRoute('article_list');
     }
     return $this->render('articles/edit.html.twig', ['form' => $form->createView()]);
      }

/**
 * @Route("/article/delete/{id}",name="delete_article")
 * @Method({"DELETE"})
 */

public function delete(Request $request, $id) {
   $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
   
   $entityManager = $this->getDoctrine()->getManager();
   $entityManager->remove($article);
   $entityManager->flush();
   
   $response = new Response();
   $response->send();
   return $this->redirectToRoute('article_list');
   }
/**
 * @Route("/category/newCat", name="new_category")
 * Method({"GET", "POST"})
 */
public function newCategory(Request $request) {
   $category = new Category();
   $form = $this->createForm(CategoryType::class,$category);
   $form->handleRequest($request);
   if($form->isSubmitted() && $form->isValid()) {
   $article = $form->getData();
   $entityManager = $this->getDoctrine()->getManager();
   $entityManager->persist($category);
   $entityManager->flush();
   }
  return $this->render('articles/newCategory.html.twig',['form'=>
  $form->createView()]);
   }
   

/**
 * @Route("/art_cat/", name="article_par_cat")
 * Method({"GET", "POST"})
 */
public function articlesParCategorie(Request $request) {
   $categorySearch = new CategorySearch();
   $form = $this->createForm(CategorySearchType::class,$categorySearch);
   $form->handleRequest($request);
   $articles= [];
   if($form->isSubmitted() && $form->isValid()) {
      $category = $categorySearch->getCategory();
      
      if ($category!="")
     $articles= $category->getArticles();
      else 
      $articles= $this->getDoctrine()->getRepository(Article::class)->findAll();
      }
      
      return $this->render('articles/articlesParCategorie.html.twig',['form' => $form->createView(),'articles' => $articles]);
      }
  
      /**
 *@Route("/con_liste",name="contact_liste")
 */
 public function contact()
 
 {
   
   return $this->render('articles/contact.html.twig'); 
    }

    /**
     * @Route("/connexion", name="securty_login")
     */
    public function login() {

      return $this->render('articles/login.html.twig') ;
   }  


}
