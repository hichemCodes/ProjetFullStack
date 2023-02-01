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
import HorrairesDouverture from './HorrairesDouverture';


const UpdateBoutique = ({operation,boutiqueUpdate,token,api,getAllBoutiques,changeOperation}) => {

  const theme = createTheme();
  const [nom,setNom] = useState('');
  const [enConge,setEnConge] = useState(0);
  const [horaires_de_ouverture,setHorrairesDeOuverture] = useState([]);
  


  useEffect( () =>{
    if(operation != "add") {
        console.log(boutiqueUpdate);
        setNom(boutiqueUpdate.nom);
        setEnConge( (boutiqueUpdate.enConge) ? 1 : 0 );
    } else {
        setEnConge(0)
    }
    console.log(operation);
  },[operation]);


  const addBoutique = () => {
    
    const datas ={
        "nom" : nom,
        "en_conge" : enConge,
        "horaires_de_ouverture" : horaires_de_ouverture
    }
    console.log(datas);
    axios.post(`${api}/boutiques`, datas,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
          response => {
              if( response.status === 201) {
                  getAllBoutiques();
                  close_pop_up();
                  setNom("");
                  setEnConge("");
                  Swal.fire('Boutique ajoutée avec succès !', '', 'success');
              }
          }
    );
      
    };

    //modifier boutique
    const updateSelectedBoutique = (id) => {
        const datas ={
            "nom" : nom,
            "en_conge" : enConge,
            "horaires_de_ouverture" : horaires_de_ouverture
        }
        console.log(datas);
        axios.put(`${api}/boutiques/${id}`, datas,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
            response => {
                if( response.status === 200) {
                    getAllBoutiques();
                    setNom("");
                    setEnConge("");
                    close_pop_up();
                    Swal.fire('Boutique Modifiée avec succès !', '', 'success');
                  
                }
            }
        );
          
    };
    

  const close_pop_up = ()=> {
    setNom("")
    setEnConge(false);
    changeOperation("");
    document.querySelector(".pop-up-update-add").classList.toggle('show_me');
    document.querySelector(".cover_add").classList.toggle('fade');
   
  }
   
    return (
        <div className="pop-up-update-add">
            
           <i class="fa-sharp fa-solid fa-xmark" onClick={()=> {close_pop_up()}}></i>
            <Grid container component="main">
                    
                <Typography component="h1" variant="h5">
                {(operation == "add") ? "Ajouter" : "Modifier" } une Boutique
                </Typography>
                <TextField
                    margin="normal"
                    required
                    fullWidth
                    name="nom"
                    label="Nom du boutique"
                    type="text"
                    id="nom_boutique"
                    value={nom}
                    onChange={(e)=> {setNom(e.target.value)}}
                    focused
                />
                <div className="body_form_containter">
                    <FormGroup>
                        <FormControlLabel label="En congé" control={<Checkbox id="check_boutique" checked={enConge == 0 ? false : true}  onChange={(e)=> {setEnConge(e.target.checked == true ? 1 : 0)}} />}  />
                    </FormGroup>

                    <HorrairesDouverture
                        changeHorrairesDeOuverture = {(new_horraires)=> {setHorrairesDeOuverture(new_horraires)}}
                        boutiqueUpdate = {boutiqueUpdate}
                    />

                </div>
                
                {
                    (operation == "add") ? 
                        <Button
                            type="submit"
                            id="boutique_btn_add"
                            fullWidth
                            variant="contained"
                            sx={{ mt: 3, mb: 2 }}
                            onClick = {()=> {addBoutique()}}
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
                            onClick = {()=> { updateSelectedBoutique(boutiqueUpdate.id)}}
                        >
                            Modifier
                    </Button>  
                    }
              
            </Grid>
        </div>
    )
}

export default UpdateBoutique