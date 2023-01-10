import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate,useLocation  } from "react-router-dom";

const ShowBoutique = ({currentShowData}) => {
    
    const navigate = useNavigate();


    const showCategorie = (id) => {
    
        navigate(`/categories/${id}`);
    }

    const showProduit = (id) => {
    
        navigate(`/produit/${id}`);
    }

    const goBack = () => {
    
        navigate(`/boutiques`);
    }
    
   
    useEffect( () =>{
       
        currentShowData.produits.map(curr => {
            console.log(curr);
        });
    },[]);
    
        
    return (
       
        <div class="show_img show_me">
            <div class="img_header">
                <span class="close_img" onClick={()=>{goBack()}}>
                    <i class="fa-solid fa-backward-step"></i>
                    Retour
                </span>
            </div>
            <div className="show_boutique">
                <div className="show_boutique_img">

                </div>
                <div className="show_boutique_content">
                     <h2>{currentShowData.nom}</h2>
                     <span className='show_boutique_conge in_work'><i class="fa-solid fa-shop"></i>{ (currentShowData.enConge) ? "EnCongé" : "Active"}   </span>
                     <span className='show_boutique_title'> Horarires</span>
                     <div className="horraire_div show_horraires">
                     <table>
                        {
                            currentShowData.horairesDeOuverture.map( jourObjet => (
                                    <tr>
                                        <td>
                                        {
                                        Object.keys(jourObjet)[0]                            
                                        }
                                        
                                        </td>	
                                        <td>
                                        { jourObjet[Object.keys(jourObjet)[0]].matin }
                                        , 
                                        { jourObjet[Object.keys(jourObjet)[0]].apreMidi }
                                        </td>
                                </tr>
                            ))
                        }
                    </table>
                    </div>
                    <span className='show_boutique_title'> Catégories (2)</span>
                    <div className="show_boutique_categories">
                        <div className="show_boutique_categoie" onClick={()=> {showCategorie(1)}}>
                            <i class="fa-solid fa-basket-shopping"></i>
                            Alimentation
                        </div>
                        <div className="show_boutique_categoie">
                            <i class="fa-solid fa-basket-shopping"></i>
                            Sport
                        </div>
                       
                    </div>
                    <span className='show_boutique_title'> Produits ({currentShowData.produits.length})</span>
                    <div className="show_boutique_produits">
                        {
                            currentShowData.produits.map(produit => (
                                <div className="show_boutique_produit"  onClick={()=> {produit(produit.id)}}>
                                    <i class="fa-brands fa-shopify"></i>
                                    <div className="show_p_info">
                                        <span>{produit.nom} </span>
                                        <span>{produit.prix} (€)</span>
                                    </div>
                                </div>
                            ))
                        }
                       
                       
                        
                    </div>
                </div>
            </div>
        </div>
    

)
}

export default ShowBoutique