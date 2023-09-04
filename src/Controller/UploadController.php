<?php

namespace App\Controller;

use App\Form\UploadType;
use App\Model\UploadData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ZipArchive;

class UploadController extends AbstractController
{
    public function __construct()
    {}

    #[Route('/', name: 'app_upload')]
    public function index(Request $request): Response
    {
        // Formulaire de sélection de dossier
        $upload_data = new UploadData();
        $upload_form = $this->createForm(UploadType::class, $upload_data);
        $upload_form->handleRequest($request);

        if ($upload_form->isSubmitted() && $upload_form->isValid()){
            //Repertoire dans lequel enregistrer nos dossiers zippés
            $root_path = dirname(dirname(getcwd()));
            
            //Chemin absolu du dossier source
            $absolute_path_folder = $root_path. DIRECTORY_SEPARATOR . $upload_data->directory;
            
            //Liste des dossiers à zipper
            $list_folder_to_zip = array_diff(scandir($absolute_path_folder), array('..', '.'));
            foreach ($list_folder_to_zip as $folder_to_zip) {
                $result= $this->zipFolder($absolute_path_folder. DIRECTORY_SEPARATOR. $folder_to_zip, $absolute_path_folder);
            }
        }

        return $this->render('upload/index.html.twig', [
            'upload_form' => $upload_form,
        ]);
    }

    public function zipFolder(string $folder_to_zip, string $absolute_path_folder): bool
    {
        //Récupération du nom dans le fichier xml pour l'archive du dossier
        if(is_dir($folder_to_zip)){
            if(file_exists($folder_to_zip. DIRECTORY_SEPARATOR. 'STUDYCFG.XML')){
            $study = simplexml_load_file($folder_to_zip. DIRECTORY_SEPARATOR. 'STUDYCFG.XML');
            } else {
                echo 'Absence du fichier studycfg.xml dans '.$folder_to_zip.'<br/>'; 
                return false;
            }
        } else return false;
        
        $zip_folder_name = $absolute_path_folder. DIRECTORY_SEPARATOR. $study->Surname. ' ' .$study->GivenName. '.zip';

        //Création de l'archive
        $zip = new ZipArchive();
        $bool = $zip->open($zip_folder_name, ZipArchive::CREATE);
        if(!$bool){
            echo 'Impossible de créer l\'archive'. $zip_folder_name;
            return false;
        }

        //Liste des fichiers à rajouter à l'archive
        $list_file = array_diff(scandir($folder_to_zip), array('..', '.'));
        foreach ($list_file as $file) {
            $bool = $zip->addFile($folder_to_zip. DIRECTORY_SEPARATOR .$file, $file);
            if($bool === false) dd('bad');
        }

        //Fermeture de l'archive
        $bool = $zip->close();
        if(!$bool){
            echo 'Problème lors de la fermeture de l\'archive';
            return false;
        }

        return true;
    }
}
