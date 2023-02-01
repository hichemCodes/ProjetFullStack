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


const AssignerProduitsToCategorie = ({api,token,allProduitsToCategorie,allProduitsNotBelongToThisCategorie,getAllCategorie}) => {
     

    const close_pop_up = ()=> {
        document.querySelector(".pop-up-assigner").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        localStorage.removeItem('categorie_to_assigner');
    }
     

    const assignerProduitsToCategorie = () => {
        let categorie_id = localStorage.getItem("categorie_to_assigner");
        let allSelected  = document.querySelectorAll(".pop-up-assigner .MuiListItem-root input[type='checkbox']:checked");
        let allSelectedProduits = [];
        
        allSelected.forEach(elem => {
            allSelectedProduits.push(parseInt(elem.id));
        });

        const datas = {
            "produits" : allSelectedProduits
        };

        axios.patch(`${api}/categories/${categorie_id}/produits`,datas,{headers: {"Authorization" : `Bearer ${token}`} }).then(
            response => {
                if( response.status === 200) {

                    Swal.fire('Catégorie Assigné aux produit(s) avec succès !', '', 'success');
                    getAllCategorie();
                    document.querySelector(".pop-up-assigner").classList.toggle('show_me');
                    document.querySelector(".cover_add").classList.toggle('fade');


                }
            }
        )
    }

    useEffect( () =>{
        
      },[allProduitsNotBelongToThisCategorie]);

    return (
        <div className="pop-up-assigner">
            
            <i class="fa-sharp fa-solid fa-xmark" onClick={()=> {close_pop_up()}}></i>
            <List sx={{ width: '100%', maxWidth: 360, bgcolor: 'background.paper' }}>

                { 
                    allProduitsToCategorie.map(produit => {
                        // console.log(produit);
                        const labelId = `${produit.id}`;
                        const amIChecked = allProduitsNotBelongToThisCategorie.some(elem => elem.id == produit.id)
                        console.log(allProduitsNotBelongToThisCategorie.length);
                        return (
                            (!amIChecked) ? (
                                <ListItem
                                    key={produit.id}
                                    disablePadding
                                    >
                                    <ListItemButton role={undefined}  dense>
                                    <ListItemIcon>
                                        <Checkbox
                                        edge="start"
                                        tabIndex={-1}
                                        inputProps={{ 'id': labelId }}
                                        defaultChecked={amIChecked}
                                    
                                        />
                                    </ListItemIcon>
                                    <ListItemText id={labelId} primary={`${produit.nom}`} />
                                    </ListItemButton>
                                </ListItem>
                            ) 
                            : ""
                        )
                        })
                }
                </List>
                <Button
                    type="submit"
                    id="boutique_btn_assigner"
                    fullWidth
                    variant="contained"
                    sx={{ mt: 3, mb: 2 }}
                    onClick = {()=> { assignerProduitsToCategorie()}}
                    >
                    Assigner
                </Button>  
        </div>
    )
}

export default AssignerProduitsToCategorie