<?php


namespace App\Controller;



use App\Entity\Reclamacion;
use App\Exception\SchoolException;
use App\Form\ReclamacionType;
use App\Manager\ReclamacionesManager;
use App\Manager\UsuarioManager;
use Dompdf\Dompdf;
use Dompdf\Options;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Flex\Configurator\ContainerConfigurator;
use Twig\Environment;

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

            return $this->redirectToRoute('app_reclamacion_show',array(
                'id'=>$reclamacion->getId(),
                'hash' => $reclamacion->getHash()
            ));
        }
        return $this->render("Default/index.html.twig",array(
            'form' => $form->createView()
        ));

    }
    /**
     * @Route("/reclamo/{id}/{hash}/mostrar", name="app_reclamacion_show", methods={"POST","GET"})
     */
    public function show($id,$hash): Response
    {
        try{
            $reclamo = $this->reclamacionesManager->searchByIdHash($id,$hash);
            return $this->render("Default/show.html.twig",array(
                'reclamo'=> $reclamo
            ));
        }
        catch (SchoolException $exception){
            $this->addFlash('danger',$exception->getMessage());
        }
        return $this->redirectToRoute('app_index');
    }
    /**
     * @Route("/reclamo/{id}/{hash}/print", name="app_reclamacion_print", methods={"POST","GET"})
     */
    public function print(Environment $twig,Request $request,$id,$hash): Response
    {
        try{

            $twig->addGlobal('url', 'http://'.$request->getHttpHost());

            $reclamo = $this->reclamacionesManager->searchByIdHash($id,$hash);
            $html= $this->renderView("Default/print.html.twig",array(
                'reclamo'=> $reclamo,
            ));
            // Configure Dompdf according to your needs
            $pdfOptions = new Options();
            $pdfOptions->setIsRemoteEnabled(true);

            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);


            // Load HTML to Dompdf
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();


            $dompdf->stream("reclamo_".$reclamo->getId().".pdf", [
                "Attachment" => true
            ]);
        }
        catch (SchoolException $exception){
            $this->addFlash('danger',$exception->getMessage());
        }
        return $this->redirectToRoute('app_index');
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
