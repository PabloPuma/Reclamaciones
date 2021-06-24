<?php


namespace App\Controller;



use App\Form\ReclamacionType;
use App\Manager\ReclamacionesManager;
use App\Manager\UsuarioManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{

    /** @var ReclamacionesManager $reclamacionesManager */
    private $reclamacionesManager;



    public function __construct( ReclamacionesManager  $reclamacionesManager)
    {
        $this->reclamacionesManager = $reclamacionesManager;
    }
    /**
     * @Route("/",name="app_index")
     */
    public function index(Request  $request){
        $reclamacion = $this->reclamacionesManager->newReclamacion();
        $form = $this->createForm(ReclamacionType::class, $reclamacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reclamacionesManager->addReclamacion($reclamacion);

            return $this->redirectToRoute('reclamacion_index');
        }
        return $this->render("Default/index.html.twig",array(
            'form' => $form->createView()
        ));

    }
    /**
     * @Route("/admin",name="app_admin_index")
     */
    public function indexAdmin(){
        return $this->render("admin/main.html.twig");

    }
    /**
     * @Route("/cooming_soom",name="cooming_soon")
     */
    public function coomingSoom(){
        return $this->render("Default/comming_soom.html.twig");

    }
    /**
     * @Route("/cooming_soom2",name="cooming_soon2")
     */
    public function inventario(){
        return $this->render("Default/comming_soom.html.twig");

    }




}
