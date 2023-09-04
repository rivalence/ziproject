/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// Remise à zéro du champ du nom du dossier
document.addEventListener('DOMContentLoaded', () => {
    let path_file = document.getElementById('upload_directory')
    path_file.value = ""
})

//Récupération du nom du dossier source
let input = document.getElementById('upload_files')
input.addEventListener('change', onChange)

function onChange(e){
    //Récupéraion du chemin relatif dans un texte
    let path_file = document.getElementById('upload_directory')
    let directory = e.target.files[0].webkitRelativePath
    directory = directory.split('/')
    path_file.value = directory[0]
}