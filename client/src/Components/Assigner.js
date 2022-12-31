import axios from 'axios';
import React, { useEffect, useState } from 'react'
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import Checkbox from '@mui/material/Checkbox';
import IconButton from '@mui/material/IconButton';
import Button from '@mui/material/Button';

const Assigner = ({config,api,nonAssigners,changeNonAssigner}) => {
     

    const close_pop_up = ()=> {
        document.querySelector(".pop-up-assigner").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        localStorage.removeItem('boutique_to_assigner');
    }
     

    const assignerProduitToBoutique = () => {
        let boutique_id = localStorage.getItem("boutique_to_assigner");
        let allSelected  = document.querySelectorAll(".pop-up-assigner .MuiListItem-root input[type='checkbox']:checked");

        if(allSelected.length > 0) {
            if(allSelected.length > 1) {
                //nomber de produit sélectionné > 1 on peut pas faire l'assignation
                //un toast pour le message d'erreure
                console.log("tu peux pas !")
            } else  {
                let idProduit = parseInt(allSelected[0].id);
                axios.patch(`${api}/boutiques/${boutique_id}/produit/${idProduit}`,config).then(
                    response => {
                        if( response.status === 200) {
                           console.log(response.data);
                           
                        }
                    }
                  )
            }
        } else {
            return;
        }

        
    }
    return (
        <div className="pop-up-assigner">
            
            <i class="fa-sharp fa-solid fa-xmark" onClick={()=> {close_pop_up()}}></i>
            <List sx={{ width: '100%', maxWidth: 360, bgcolor: 'background.paper' }}>

                { 
                    nonAssigners.map(produit => {
                        console.log(produit);
                        const labelId = `${produit.id}`;
                        return (
                        <ListItem
                        key={produit.id}
                     
                        disablePadding
                        >
                        <ListItemButton role={undefined}  dense>
                        <ListItemIcon>
                            <Checkbox
                            edge="start"
                            tabIndex={-1}
                            disableRipple
                            inputProps={{ 'id': labelId }}
                            />
                        </ListItemIcon>
                        <ListItemText id={labelId} primary={`${produit.nom} (${produit.prix} €)`} />
                        </ListItemButton>
                        </ListItem>
                    
                    )})
                }
                </List>
                <Button
                    type="submit"
                    id="boutique_btn_assigner"
                    fullWidth
                    variant="contained"
                    sx={{ mt: 3, mb: 2 }}
                    onClick = {()=> { assignerProduitToBoutique()}}
                    >
                    Assigner
                </Button>  
        </div>
    )
}

export default Assigner