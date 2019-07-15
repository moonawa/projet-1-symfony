<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employe;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\EmployeRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\Entytype;
use App\Form\EmployeType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(EmployeRepository $repo)
    {
        $employes = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'employes' => $employes
        ]);
    }

    /**
     *  @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

     /**
     * @Route ("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Employe $employe = null, Request $request, ObjectManager $manager){
        
        if(!$employe){
            $employe = new Employe();
        }

         
        //$form = $this->createFormBuilder($employe)
       // ->add('nom')
        //->add('prenom') 
        //->add('hbd', DateType::class, [
            //'widget' => 'single_text',
            // this is actually the default format for single_text
            //'format' => 'yyyy-MM-dd',
       // ])     
        //->add('email')
                            
        //->getForm();

        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //$employe->setHbd(new \Date());

            $manager->persist($employe);
            $manager->flush();
            return $this->render('blog/show.html.twig',
            ['employe' => $employe]
    );
           
        }
        

        return $this->render('blog/create.html.twig', [
            'formEmploye' => $form->createView(),
            'editMode' => $employe->getId() !== null
        ]);
    }
    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Employe $employe){
         return $this->render('blog/show.html.twig',
        ['employe' => $employe]);
}
}