import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate  } from "react-router-dom";

  

const Produit = ({api,token,produit,getAllProduits,produits,changeOperation,changeProduitUpdate,changeAllCategiriesOfSelectedProduit}) => {

    const navigate = useNavigate();

    const DeleteProduit = (id) => {
        Swal.fire({
            title: 'Est-ce que vous êtes sûr de vouloir supprimer ce produit',
            showCancelButton: true,
            confirmButtonText: 'Supprimer',
            cancelButtonText: "Annuler",
          }).then((result) => {
            
            if (result.isConfirmed) {
                  produits.filter((item) => item.id !== id);
                  Swal.fire('Produit supprimée avec succès !', '', 'success');
                  axios.delete(`${api}/produits/${id}`,{headers: {"Authorization" : `Bearer ${token}`} }).then(
                      response => {
                            if( response.status === 200) {
                               getAllProduits();
                            }
                      }
                  )
             
            } 
          })
    }

    const updateProduit = (id,boutiqueObj,operation) => {
        changeOperation(operation);
        changeProduitUpdate(boutiqueObj);
        
        document.querySelector(".pop-up-update-add").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        
    }

    const assignerProduitToCategories = (produit) => {
        
        document.querySelector(".pop-up-assigner").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        changeAllCategiriesOfSelectedProduit(produit.categories);
        localStorage.setItem("produit_to_assigner",produit.id)
        
    }

    const showProduit = (id) => {

        navigate(`/boutiques/${id}`); 
    }

    return (

        <div className="card">
            <i class="fa-brands fa-shopify"></i>
            <div className="card__image">
            
                <div className="show_option">
                        <div className="cover_option">
                            <i class="fa-solid fa-pen-to-square" title='modifier' onClick={()=>{updateProduit(produit.id,produit,"update")}}></i>
                            <i class="fa-sharp fa-solid fa-trash" onClick={()=>{DeleteProduit(produit.id)}} title='supprimer'></i>
                            <i class="fa-sharp fa-solid fa-cart-plus" onClick={()=>{assignerProduitToCategories(produit)}}></i>
                        </div>
                </div>
                
            </div>
            <div className="card__copy" onClick={()=> {showProduit(produit.id)}}>
                <h1 className='card-name'>{produit.nom}</h1>
                <div className='card-item-title'>
                    Catégories : 
                    { 
                        produit.categories.map( categorie => (
                           <span>{  `${categorie.nom}` }  </span> 
                        ))
                    }
                    
                </div>
                { (produit.boutiqueId == null) ? "" 
                        : (
                            <div className='card-item-title'>
                                Boutique : 
                                 <span>{produit.boutiqueId.nom}</span>
                            </div>
                        ) 
                }
              
                <div className="prix-produit ">
                    <span className='card-item-title'>{produit.prix} € </span>
                </div>
            </div>
        
            <div className="cover_description">
                    <span>{produit.description}</span>
            </div>
        </div>

)
}

export default Produit