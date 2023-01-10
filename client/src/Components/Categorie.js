import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate  } from "react-router-dom";

  

const Categorie = ({api,token,categorie,getAllCategories,categories,changeOperation,changeCtegorieUpdate,changeAllProduitsNotBelongToThisCategorie,changeCurrentShowData}) => {

    const navigate = useNavigate();

    const DeleteCategorie = (id) => {
        Swal.fire({
            title: 'Est-ce que vous êtes sûr de vouloir supprimer cette categorie',
            showCancelButton: true,
            confirmButtonText: 'Supprimer',
            cancelButtonText: "Annuler",
          }).then((result) => {
            
            if (result.isConfirmed) {
                  categories.filter((item) => item.id !== id);
                  Swal.fire('Categorie supprimée avec succès !', '', 'success');
                  axios.delete(`${api}/categories/${id}`,{headers: {"Authorization" : `Bearer ${token}`} }).then(
                      response => {
                            if( response.status === 200) {
                               getAllCategories();
                            }
                      }
                  )
             
            } 
          })
    }

    const updateCategorie = (id,categorieObj,operation) => {
        changeOperation(operation);
        changeCtegorieUpdate(categorieObj);
        document.querySelector(".pop-up-update-add").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        
    }

    const assignerCategorieToProduits = (produit) => {
        
        document.querySelector(".pop-up-assigner").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        changeAllProduitsNotBelongToThisCategorie(categorie.produits);
        localStorage.setItem("categorie_to_assigner",produit.id)
        
    }

    const showCategorie = (id) => {
        changeCurrentShowData(categorie);
        navigate(`/categories/${id}`); 
    }

    return (

        <div className="card">
            <i class="fa-brands fa-shopify"></i>
            <div className="card__image">
            
                <div className="show_option">
                        <div className="cover_option">
                            <i class="fa-solid fa-pen-to-square" title='modifier' onClick={()=>{updateCategorie(categorie.id,categorie,"update")}}></i>
                            <i class="fa-sharp fa-solid fa-trash" onClick={()=>{DeleteCategorie(categorie.id)}} title='supprimer'></i>
                            <i class="fa-sharp fa-solid fa-cart-plus" onClick={()=>{assignerCategorieToProduits(categorie)}}></i>
                        </div>
                </div>
                
            </div>
            <div className="card__copy" onClick={()=> {showCategorie(categorie.id)}}>
                <h1 className='card-name'>{categorie.nom}</h1>
                <div className='card-item-title'>
                    Nombre des produits :  
                    { 
                       categorie.produits.length
                    }
                    
                </div>
               
            </div>
        </div>

)
}

export default Categorie