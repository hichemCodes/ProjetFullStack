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


const UpdateBoutique = ({operation,boutiqueUpdate,config,api,getAllBoutiques,changeOperation}) => {

  const theme = createTheme();
  const [nom,setNom] = useState('');
  const [enConge,setEnConge] = useState(false);
  const [horaires_de_ouverture,setHorrairesDeOuverture] = useState([]);
  


  useEffect( () =>{
    if(operation != "add") {
        console.log(boutiqueUpdate);
        setNom(boutiqueUpdate.nom);
        setEnConge(boutiqueUpdate.en_conge);
    }
  },[operation]);

  const horaires_de_ouvertureValue = ([{"lundi":{"matin":"8h-12h","apreMidi":"14h-18h"}},{"mardi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"mercredi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"jeudi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"vendredi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"samedi":{"matin":"8h-12h","apreMidi":"14h-20h"}},{"dimanche":{"matin":"8h-12h","apreMidi":"14h-20h"}}]);

  const addBoutique = () => {
    
    const datas ={
        "nom" : nom,
        "en_conge" : enConge,
        "horaires_de_ouverture" : horaires_de_ouvertureValue
    }
    console.log(datas);
    axios.post(`${api}/boutiques`, datas,config).then(
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
            "horaires_de_ouverture" : horaires_de_ouvertureValue
        }
        console.log(datas);
        axios.put(`${api}/boutiques/${id}`, datas,config).then(
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
                <FormGroup>
                    <FormControlLabel label="En congé" control={<Checkbox id="check_boutique" checked={enConge}  onChange={(e)=> {setEnConge(e.target.checked)}} />}  />
                </FormGroup>
                
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