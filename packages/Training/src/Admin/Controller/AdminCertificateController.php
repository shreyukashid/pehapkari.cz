<?php declare(strict_types=1);

namespace Pehapkari\Training\Admin\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Pehapkari\Training\Certificate\CertificateGenerator;
use Pehapkari\Training\Form\GenerateCertificateFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AdminCertificateController extends EasyAdminController
{
    /**
     * @var CertificateGenerator
     */
    private $certificateGenerator;

    public function __construct(CertificateGenerator $certificateGenerator)
    {
        $this->certificateGenerator = $certificateGenerator;
    }

    /**
     * @Route(path="/create-certificate/", name="create_certificate", methods={"GET", "POST"})
     */
    public function createCertificate(Request $request): Response
    {
        $form = $this->createForm(GenerateCertificateFormType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $certificate = $this->certificateGenerator->generateForTrainingTermAndName(
                    $data['training_term'],
                    $data['name']
                );

                return $this->file($certificate);
            }
        }

        return $this->render('certificate/create_certificate.twig', [
            'form' => $form->createView(),
        ]);
    }
}
