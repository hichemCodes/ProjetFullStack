import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate,useLocation  } from "react-router-dom";
import Loader from './loader';

const ShowCategorie = ({currentShowData,token,api,changeCurrentShowData}) => {
    
    const navigate = useNavigate();
    const [is_loading,setIsloading] = useState(true);


    const showProduit = (id) => {
    
        navigate(`/produits/${id}`);
    }


    const goBack = () => {
    
        navigate(`/categories`);
    }
    
   
    useEffect( () =>{

        if(currentShowData.length == 0) {
            axios.get(`${api}/categories/15`,{headers: {"Authorization" : `Bearer ${token}`} }).then(
                response => {
                    if( response.status === 200) {
                        changeCurrentShowData(response.data[0]);
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
                       
                        <span className='show_boutique_title'> Produits 
                               {(currentShowData.produits != null) ? ` (${currentShowData.produits.lengt})` : ''}    
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

export default ShowCategorie