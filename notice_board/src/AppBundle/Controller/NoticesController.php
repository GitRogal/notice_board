<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notices;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Transliterator;

/**
 * Notice controller.
 *
 * @Route("notices")
 */
class NoticesController extends Controller
{
    /**
     * Lists all notice entities.
     *
     * @Route("/", name="notices_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notices = $em->getRepository('AppBundle:Notices')->findAll();

        return $this->render('notices/index.html.twig', array(
            'notices' => $notices,
        ));
    }

    /**
     * Creates a new notice entity.
     * @Route("/new", name="notices_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $notice = new Notices();
        $form = $this->createForm('AppBundle\Form\NoticesType', $notice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['imageName']->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
//                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
                $notice->setImageName($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($notice);
            $em->flush();

            return $this->redirectToRoute('notices_show', array('id' => $notice->getId()));
        }

        return $this->render('notices/new.html.twig', array(
            'notice' => $notice,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a notice entity.
     *
     * @Route("/{id}", name="notices_show", methods={"GET"})
     */
    public function showAction(Notices $notice)
    {
        $deleteForm = $this->createDeleteForm($notice);

        return $this->render('notices/show.html.twig', array(
            'notice' => $notice,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notice entity.
     *
     * @Route("/{id}/edit", name="notices_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Notices $notice)
    {
        $deleteForm = $this->createDeleteForm($notice);
        $editForm = $this->createForm('AppBundle\Form\NoticesType', $notice);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notices_edit', array('id' => $notice->getId()));
        }

        return $this->render('notices/edit.html.twig', array(
            'notice' => $notice,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notice entity.
     *
     * @Route("/{id}", name="notices_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Notices $notice)
    {
        $form = $this->createDeleteForm($notice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notice);
            $em->flush();
        }

        return $this->redirectToRoute('notices_index');
    }

    /**
     * Creates a form to delete a notice entity.
     *
     * @param Notices $notice The notice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notices $notice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notices_delete', array('id' => $notice->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
