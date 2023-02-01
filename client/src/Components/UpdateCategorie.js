import React, { useEffect, useState } from 'react'
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import FormControlLabel from '@mui/material/FormControlLabel';
import Link from '@mui/material/Link';
import Paper from '@mui/material/Paper';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import FormGroup from '@mui/material/FormGroup';
import Checkbox from '@mui/material/Checkbox';
import axios from 'axios';
import Swal from 'sweetalert2';


const UpdateCategorie = ({operation,categorieUpdate,token,api,getAllCategorie,changeOperation}) => {

  const theme = createTheme();
  const [nom,setNom] = useState('');


  useEffect( () => {

    if(operation != "add") {
        setNom(categorieUpdate.nom);
    } else {
        setNom("");
    }

  },[operation]);


  const addProduit = () => {
    
    const datas = {
        "nom" : nom,
    }

    axios.post(`${api}/categories`, datas, {headers: {"Authorization" : `Bearer ${token}`} }).then(
          response => {
              if( response.status === 201) {
                  getAllCategorie();
                  close_pop_up();
                  Swal.fire('Categorie ajoutée avec succès !', '', 'success');
              }
          }
    );
      
    };

    //modifier categotie
    const updateSelectedCategorie = (id) => {
        
        const datas = {
            "nom" : nom,
        }

        axios.put(`${api}/categories/${id}`,datas, {headers: {"Authorization" : `Bearer ${token}`} }).then(
            response => {
                if( response.status === 200) {
                    getAllCategorie();
                    setNom("");
                    close_pop_up();
                    Swal.fire('Categorie Modifiée avec succès !', '', 'success');
                  
                }
            }
        );
          
    };
    

  const close_pop_up = ()=> {
    setNom("")
    changeOperation("");
    document.querySelector(".pop-up-update-add").classList.toggle('show_me');
    document.querySelector(".cover_add").classList.toggle('fade');
   
  }


   
    return (
        <div className="pop-up-update-add">
            
           <i class="fa-sharp fa-solid fa-xmark" onClick={()=> {close_pop_up()}}></i>
            <Grid container component="main">
                    
                <Typography component="h1" variant="h5">
                {(operation == "add") ? "Ajouter" : "Modifier" } une categorie
                </Typography>
                <TextField
                    margin="normal"
                    required
                    fullWidth
                    name="nom"
                    label="Nom du categorie"
                    type="text"
                    id="nom_categorie"
                    value={nom}
                    onChange={(e)=> {setNom(e.target.value)}}
                    focused
                />  
                {
                    (operation == "add") ? 
                        <Button
                            type="submit"
                            id="boutique_btn_add"
                            fullWidth
                            variant="contained"
                            sx={{ mt: 3, mb: 2 }}
                            onClick = {()=> {addProduit()}}
                        >
                            Ajouter
                        </Button>  
                    : 
                     
                        <Button
                            type="submit"
                            id="boutique_btn_update"
                            fullWidth
                            variant="contained"
                            sx={{ mt: 3, mb: 2 }}
                            onClick = {()=> { updateSelectedCategorie(categorieUpdate.id)}}
                        >
                            Modifier
                        </Button>  
                    
                }
              
            </Grid>
        </div>
    )
}

export default UpdateCategorie