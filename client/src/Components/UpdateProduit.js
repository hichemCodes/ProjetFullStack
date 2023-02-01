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


const UpdateProduit = ({operation,produitUpdate,token,api,getAllProduits,changeOperation}) => {

  const theme = createTheme();
  const [nom,setNom] = useState('');
  const [prix,setPrix] = useState(0);
  const [description,setDescription] = useState("");



  useEffect( () => {

    if(operation != "add") {
        setNom(produitUpdate.nom);
        setDescription(produitUpdate.description);
        setPrix(produitUpdate.prix);
        console.log(produitUpdate)
    } else {
        setNom("");
        setDescription("");
        setPrix(0);
    }

  },[operation]);


  const addProduit = () => {
    
    const datas = {
        "nom" : nom,
        "prix" : prix,
    }

    axios.post(`${api}/produits`, datas,{ headers: {"Authorization" : `Bearer ${token}`} }).then(
          response => {
              if( response.status === 201) {
                  getAllProduits();
                  close_pop_up();
                  Swal.fire('Produit ajoutée avec succès !', '', 'success');
              }
          }
    );
      
    };

    //modifier boutique
    const updateSelectedProduit = (id) => {
        
        const datas ={
            "nom" : nom,
            "prix" : prix,
            "description" : description
        }
        console.log(datas);
        axios.put(`${api}/produits/${id}`, datas,{ headers: {"Authorization" : `Bearer ${token}`} }).then(
            response => {
                if( response.status === 200) {
                    getAllProduits();
                    setNom("");
                    setPrix("");
                    setDescription("");
                    close_pop_up();
                    Swal.fire('Produit Modifiée avec succès !', '', 'success');
                  
                }
            }
        );
          
    };
    

  const close_pop_up = ()=> {
    setNom("")
    setPrix(0);
    setDescription(0);
    changeOperation("");
    document.querySelector(".pop-up-update-add").classList.toggle('show_me');
    document.querySelector(".cover_add").classList.toggle('fade');
   
  }
   
    return (
        <div className="pop-up-update-add">
            
           <i class="fa-sharp fa-solid fa-xmark" onClick={()=> {close_pop_up()}}></i>
            <Grid container component="main">
                    
                <Typography component="h1" variant="h5">
                {(operation == "add") ? "Ajouter" : "Modifier" } un Produit
                </Typography>
                <TextField
                    margin="normal"
                    required
                    fullWidth
                    name="nom"
                    label="Nom du produit"
                    type="text"
                    id="nom_produit"
                    value={nom}
                    onChange={(e)=> {setNom(e.target.value)}}
                    focused
                />
               <TextField
                    margin="normal"
                    required
                    fullWidth
                    name="prix"
                    label="Prix du produit"
                    type="number"
                    id="prix_produit"
                    value={prix}
                    onChange={(e)=> {setPrix(e.target.value)}}
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
                     <React.Fragment>
                        <TextField
                        margin="normal"
                        id="outlined-multiline-static"
                        multiline
                        name="description"
                        label="Description du produit"
                        value={description}
                        onChange={(e)=> {setDescription(e.target.value)}}
                        focused
                        rows={6}
                        
                        />
                        <Button
                            type="submit"
                            id="boutique_btn_update"
                            fullWidth
                            variant="contained"
                            sx={{ mt: 3, mb: 2 }}
                            onClick = {()=> { updateSelectedProduit(produitUpdate.id)}}
                        >
                            Modifier
                        </Button>  
                    </React.Fragment>
                }
              
            </Grid>
        </div>
    )
}

export default UpdateProduit