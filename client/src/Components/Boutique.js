import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate  } from "react-router-dom";

  

const Boutique = ({boutique,getAllBoutiques,boutiques,changeOperation,changeBoutiqueUpdate,getAllProduitsNonAssigner,changeCurrentShowData}) => {

    const [api,setApi] = useState("http://localhost:8080/api");
    const [token,setToken] = useState(localStorage.getItem("token"));
    const navigate = useNavigate();

    const DeleteBoutique = (id) => {
        Swal.fire({
            title: 'Est-ce que vous êtes sûr de vouloir supprimer la boutique',
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
                  boutiques.filter((item) => item.id !== id);
                  Swal.fire('Boutique supprimée avec succès !', '', 'success');
                  axios.delete(`${api}/boutiques/${id}`,{ headers: {"Authorization" : `Bearer ${token}`} }).then(
                      response => {
                            if( response.status === 200) {
                               getAllBoutiques();
                            }
                      }
                  )
            } 
          })
    }

    const updateBoutique = (id,boutiqueObj,operation) => {
        changeOperation(operation);
        changeBoutiqueUpdate(boutiqueObj);
        
        document.querySelector(".pop-up-update-add").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');

    }

    const AssignerBoutique = (id) => {

        document.querySelector(".pop-up-assigner").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
        getAllProduitsNonAssigner();
        localStorage.setItem("boutique_to_assigner",id)

    }

    const showBoutique = (id) => {
        changeCurrentShowData(boutique);
        navigate(`/boutiques/${id}`); 
      
    }


    return (

        <div className="card">
        <div className="card__image">
           <div className="show_option">
                <div className="cover_option">
                    <i class="fa-solid fa-pen-to-square" title='modifier' onClick={()=>{updateBoutique(boutique.id,boutique,"update")}}></i>
                    <i class="fa-sharp fa-solid fa-trash" onClick={()=>{DeleteBoutique(boutique.id)}} title='supprimer'></i>
                    <i class="fa-sharp fa-solid fa-cart-plus" onClick={()=>{AssignerBoutique(boutique.id)}}></i>
                </div>
                <i class="fa-solid fa-store"></i>
           </div>
        </div>
        
        <div className="card__copy" onClick={()=> {showBoutique(boutique.id)}}>
            <h1 className='card-name'>{boutique.nom}</h1>
            <span className='card-item-title'>Crée le : <span>{boutique.dateDeCreation}</span></span>
            <span className='card-item-title'>En congé : <span>{ (boutique.enConge) ? "oui" : "non"  }</span></span>
            <span className='card-item-title'>Nombre de Produits : <span>{ boutique.produits.length}</span></span>
            <span className='card-item-title'>Horraires : <i class="fa-solid fa-calendar-days"></i> </span>
            <div className="horraire_div">
                <table>
                    {
                        boutique.horairesDeOuverture.map( jourObjet => (
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
            
        </div>
       
    </div>

)
}

export default Boutique