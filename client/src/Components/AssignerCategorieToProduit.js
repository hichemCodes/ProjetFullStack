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
import Swal from 'sweetalert2';


const AssignerCategorieToProduit = ({api,token,allCategorieToProduit,allCategiriesOfSelectedProduit,getAllProduits}) => {
     

    const close_pop_up = ()=> {
        document.querySelector(".pop-up-assigner").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        localStorage.removeItem('produit_to_assigner');
    }
     

    const assignerProduitToCategories = () => {
        let produit_id = localStorage.getItem("produit_to_assigner");
        let allSelected  = document.querySelectorAll(".pop-up-assigner .MuiListItem-root input[type='checkbox']:checked");
        let allSelectedCategories = [];
        allSelected.forEach(elem => {
            allSelectedCategories.push(parseInt(elem.id));
        })

        const datas = {
            "categories" : allSelectedCategories
        };
        axios.patch(`${api}/produits/${produit_id}/categories`,datas,{headers: {"Authorization" : `Bearer ${token}`} }).then(
            response => {
                if( response.status === 200) {

                    Swal.fire('Produit Assigné avec succès !', '', 'success');
                    getAllProduits();
                    allSelected.forEach(elem => {
                        elem.checked = false;
                    });
                    document.querySelector(".pop-up-assigner").classList.toggle('show_me');
                    document.querySelector(".cover_add").classList.toggle('fade');

                    
                }
            }
        )
    }

    useEffect( () =>{
        
      },[allCategorieToProduit]);
   

    return (
        <div className="pop-up-assigner">
            
            <i class="fa-sharp fa-solid fa-xmark" onClick={()=> {close_pop_up()}}></i>
            <List sx={{ width: '100%', maxWidth: 360, bgcolor: 'background.paper' }}>

                { 
                    allCategorieToProduit.map(categorie => {
                       
                        const labelId = `${categorie.id}`;
                        const amIChecked = allCategiriesOfSelectedProduit.some(elem => elem.id == categorie.id);
                        console.log(amIChecked);
                        return (
                        <ListItem
                            key={categorie.id}
                            disablePadding
                            >
                            <ListItemButton role={undefined} >
                            <ListItemIcon>
                                <Checkbox
                                edge="start"
                                tabIndex={-1}
                                inputProps={{ 'id': labelId }}
                                defaultChecked={amIChecked}
                               
                                />
                            </ListItemIcon>
                            <ListItemText id={labelId} primary={`${categorie.nom}`} />
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
                    onClick = {()=> { assignerProduitToCategories()}}
                    >
                    Assigner
                </Button>  
        </div>
    )
}

export default AssignerCategorieToProduit