<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\GenerateForm;
use AppBundle\Form\GenerateFormType;
use AppBundle\Lib\Generator;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request){
        $generateForm = new GenerateForm();
        $generateForm->setNumberOfChars(0);
        $generateForm->setNumberOfCodes(0);
        
        $form = $this->createForm(new GenerateFormType(),$generateForm);
        $form->handleRequest($request);
        
        if($request->isMethod("POST")){
            $formData = $form->getData();
            $gen = new Generator($this->get('logger'));
            //gdyby ktoś chcial uzyc bazy danych 
//            $gen->setEMR($this->getDoctrine()->getManager(), 
//                    $this->getDoctrine()->getRepository('AppBundle:Code'));
            $gen->generate($formData->getNumberOfCodes(), $formData->getNumberOfChars());
            
            return $this->responseHeader($gen);
        }
        
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'form' => $form->createView()
        ));
    }
    
    private function responseHeader(&$generator){
        $response = new Response();
        $response->headers->set('Content-type', 'text/plain');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $generator->getNameFile()));
        $response->headers->set('Content-Length', filesize($generator->getNameFile()));
        $response->sendHeaders();

        $response->setContent(file_get_contents($generator->getNameFile()));

        return $response;
    }
}
