import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate  } from "react-router-dom";

  

const Produit = ({produit,getAllProduits,produits,changeOperation,changeBoutiqueUpdate}) => {

    const [api,setApi] = useState("http://localhost:8000/api");
    const [token,setToken] = useState(localStorage.getItem("token"));

    const navigate = useNavigate();

    const DeleteProduit = (id) => {
        Swal.fire({
            title: 'Est-ce que vous êtes sûr de vouloir supprimer ce produit',
            showCancelButton: true,
            confirmButtonText: 'Supprimer',
            cancelButtonText: "Annuler",
          }).then((result) => {
            
            if (result.isConfirmed) {
                const config = {
                    headers: { 
                      'Authorization': `Bearer ${token}`,
                      'Accept': 'application/json',
                      'Content-Type': 'application/json'}
                  };
                  produits.filter((item) => item.id !== id);
                  Swal.fire('Produit supprimée avec succès !', '', 'success');
                  axios.delete(`${api}/produits/${id}`,{ headers: {"Authorization" : `Bearer ${token}`} }).then(
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
        /*changeOperation(operation);
            changeBoutiqueUpdate(boutiqueObj);
            
            document.querySelector(".pop-up-update-add").classList.toggle('show_me');
            document.querySelector(".cover_add").classList.toggle('fade');
        */
    }

    const AssignerProduit = (id) => {
        /*
        /*document.querySelector(".pop-up-assigner").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        getAllProduitsNonAssigner();
        localStorage.setItem("boutique_to_assigner",id)
        */
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
                            <i class="fa-sharp fa-solid fa-cart-plus" onClick={()=>{AssignerProduit(produit.id)}}></i>
                        </div>
                </div>
                
            </div>
            <div className="card__copy" onClick={()=> {showProduit(produit.id)}}>
                <h1 className='card-name'>{produit.nom}</h1>
                <span className='card-item-title'>Catégories : <span>{ produit.categories  }</span></span>
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