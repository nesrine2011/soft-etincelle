<?php

namespace App\Controller;

// SendInBlue
use App\Entity\Devis;
use App\Entity\Utilisateur;

// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;

// require_once 'App/PHPMailer/src/Exception.php';
// require_once 'App/PHPMailer/src/PHPMailer.php';
// require_once 'App/PHPMailer/src/SMTP.php';

use App\Form\DevisFormType;
use App\Form\RegistrationFormType;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{

    // #[Route('/sendMail', name:'sendMail')]
//     public static function sendMail()
//   {

//     $mail = new PHPMailer(true);

//     try {
//       // Server settings // ? -> Informations de connexion à SendInBlue (c'est une connexion)
//       $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//       $mail->isSMTP();                                            //Send using SMTP
//       $mail->Host       = 'smtp-relay.sendinblue.com';                     //Set the SMTP server to send through // ? Site Hébergeur qui va permettre d'envoyer les mails
//       $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//       $mail->Username   = 'nesrine.boudjellel1@gmail.com';                     //SMTP username // ? Mon email inscrit dans Sendinblue
//       $mail->Password   = 'xsmtpsib-7fd3d2a4dbf104a5047830ad9ed5985b4930e4380d11fa9872994439f4d073aa-94fk7ANxtsJcVyS2';  // ? Mot de passe ou clé SMTP (voir postIt violet) secret !                             //SMTP password
//       $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption --> Le truc de base (voir Github) utilisait une encryption spécifique alors que tls est plus 
//       $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

//       //Recipients
//       $mail->setFrom('dounia.vaillant@gmail.com', 'Test');
//       $mail->addAddress('nesrine.boudjellel1@gmail.com', 'Quelqu\'un');     //Add a recipient
//       // $mail->addAddress('ellen@example.com');               //Name is optional
//     //   $mail->addReplyTo('dounia.vaillant@gmail.com', 'Information');
//       // $mail->addCC('cc@example.com');
//       // $mail->addBCC('bcc@example.com');

//       //Attachments = Pièces jointes
//       // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//       // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//       //Content
//       $mail->isHTML(true);                                  //Set email format to HTML
//       $mail->Subject = 'Mon sujet'; // utf8_decode --deprécié??--
//       $mail->Body    = 'Voici mon texte en HTML <b>in bold!</b>';
//       $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//       $mail->send();
//       echo 'Message envoyé';
//     } catch (Exception $e) {
//       echo "Le message ne peut pas être envoyé. Mailer Error: {$mail->ErrorInfo}";
//     }


//     //  include(VIEWS."app/sendMail.php" ) ;
//   }

    #[Route('/app', name: 'app_app')]
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {

        // dd($_SERVER);
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/services', name: 'services')]
    public function services(): Response
    {
        return $this->render('app/services.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/tarifs', name: 'tarifs')]
    public function tarifs(): Response
    {
        return $this->render('app/tarifs.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('app/contact.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
    
    #[Route('/mentions', name: 'mentions')]
    public function mentions(): Response
    {
        return $this->render('app/mentions.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/politique', name: 'politique')]
    public function politique(): Response
    {
        return $this->render('app/politique.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response
    {
        return $this->render('app/cgu.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/backoffice', name: 'backoffice')]
    public function backoffice(UtilisateurRepository $repo): Response
    {

        $utilisateurs = $repo->findAll();
        return $this->render('admin/backoffice.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/devis', name: 'devis')]
    public function devis(Request $request, EntityManagerInterface $entityManager): Response
    {
        $devis = new Devis();
        $form = $this->createForm(DevisFormType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre demande de devis a bien été envoyée !');
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->redirectToRoute('app_accueil', [
                
            ]);
  
        }

        return $this->render('app/devis.html.twig', [
            'controller_name' => 'AppController',
            'devisForm' => $form->createView()
        ]);
    }

    #[Route('/admin/devis', name: 'admin_devis')]
    public function admin_devis(DevisRepository $repo): Response
    {
        $devis=$repo->findAll();
        return $this->render('admin/afficheDevis.html.twig', [
            'devis'=>$devis,
           
        ]);
    }
}
