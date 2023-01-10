import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate,useLocation  } from "react-router-dom";
import Loader from './loader';

const ShowProduit = ({currentShowData,token,api,changeCurrentShowData}) => {
    
    const navigate = useNavigate();
    const [is_loading,setIsloading] = useState(true);


    const showCategorie = (id) => {
    
        navigate(`/categories/${id}`);
    }


    const goBack = () => {
    
        navigate(`/produits`);
    }
    
   
    useEffect( () =>{
        console.log(currentShowData);
        if(currentShowData.length == 0) {
            axios.get(`${api}/produits/105`,{headers: {"Authorization" : `Bearer ${token}`} }).then(
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
                        <span className='show_boutique_conge'>{currentShowData.prix} €   </span>

                        <span className='show_boutique_title'> Boutique</span>
                        <div className="horraire_div show_horraires">
                            {(currentShowData.boutiqueId != null) ? currentShowData.boutiqueId.nom : ''}
                        </div>
                        <span className='show_boutique_title'> Description </span>
                        <div className="horraire_div show_horraires">
                            {currentShowData.description}
                        </div>

                        <span className='show_boutique_title'> Catégories 
                               {(currentShowData.categories != null) ? ` (${currentShowData.categories.lengt})` : ''}    
                         </span>
                        <div className="show_boutique_categories">
                            {(currentShowData.categories == null) ? '' : (
                                
                               
                                currentShowData.categories.map(categorie => (
                                    <div className="show_boutique_categoie" onClick={()=> {showCategorie(categorie.id)}}>
                                        <i class="fa-solid fa-basket-shopping"></i>
                                        {categorie.nom}
                                    </div>
                                ))
                               
                                    
                            )}
                               
                        
                        
                        </div>
                        
                    </div>
                </div>
            </div>
   

)
}

export default ShowProduit