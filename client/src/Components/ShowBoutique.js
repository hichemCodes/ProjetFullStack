import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate,useLocation  } from "react-router-dom";
import Loader from './loader';


const ShowBoutique = ({currentShowData,token,api,changeCurrentShowData}) => {
    
    const navigate = useNavigate();
    const [is_loading,setIsloading] = useState(true);

    const showCategorie = (id) => {
    
        navigate(`/categories/${id}`);
    }

    const showProduit = (id) => {
    
        navigate(`/produits/${id}`);
    }

    const goBack = () => {
    
        navigate(`/boutiques`);
    }
    
   
    useEffect( () =>{
        if(currentShowData.length == 0) {
            axios.get(`${api}/boutiques/36`,{headers: {"Authorization" : `Bearer ${token}`} }).then(
                response => {
                    if( response.status === 200) {
                        changeCurrentShowData(response.data);
                        setIsloading(false);
                    }
                }
            )
        
        } else {
            setIsloading(false);
        }
    },[]);
    
        
    return (
        (is_loading) ? (<Loader/>) 
        : 
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
                     {(currentShowData.horairesDeOuverture == null) ? '' : (
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
                     )}
                  
                    </div>
                    {/*<span className='show_boutique_title'> Catégories (2)</span>
                    <div className="show_boutique_categories">
                            {/*
                                currentShowData.produits.map(produit => (
                                    <div className="show_boutique_categoie" onClick={()=> {showCategorie(1)}}>
                                        <i class="fa-solid fa-basket-shopping"></i>
                                        Alimentation
                                    </div>
                                ))</div>
                                */}
                       
                       
                    
                    <span className='show_boutique_title'>
                         Produits 
                         {(currentShowData.produits != null) ? ` (${currentShowData.produits.length})` : ''}     
                    </span>
                    <div className="show_boutique_produits">
                    {(currentShowData.produits == null) ? '' : (
                            
                        currentShowData.produits.map(produit => (
                            <div className="show_boutique_produit"  onClick={()=> {showProduit(produit.id)}}>
                                <i class="fa-brands fa-shopify"></i>
                                <div className="show_p_info">
                                    <span>{produit.nom} </span>
                                    <span>{produit.prix} (€)</span>
                                </div>
                            </div>
                        ))
                            
                     )}
                       
                       
                       
                        
                    </div>
                </div>
            </div>
        </div>
    

)
}

export default ShowBoutique