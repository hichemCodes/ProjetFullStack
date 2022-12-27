import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate  } from "react-router-dom";

  

const Boutique = ({boutique,getAllBoutiques}) => {

    const [api,setApi] = useState("http://localhost:8000/api");
    const [token,setToken] = useState(localStorage.getItem("token"));
    const navigate = useNavigate();

    const DeleteBoutique = (id) => {
        console.log(id);
        Swal.fire({
            title: 'Est-ce que vous êtes sûr de vouloir supprimer la boutique',
            showCancelButton: true,
            confirmButtonText: 'Supprimer',
            cancelButtonText: "Annuler",
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                const config = {
                    headers: { 
                      'Authorization': `Bearer ${token}`,
                      'Accept': 'application/json',
                      'Content-Type': 'application/json'}
                  };
                  const datas = {};
                  axios.delete(`${api}/boutiques/${id}`,{ headers: {"Authorization" : `Bearer ${token}`} }).then(
                      response => {
                            if( response.status === 200) {
                               getAllBoutiques();
                               Swal.fire('Saved!', '', 'success');
                            }
                      }
                  )
             
            } 
          })
    }

    const updateBoutique = (id) => {
       
    }

    const showBoutique = (id) => {

        navigate(`/boutiques/${id}`); 
    }


    return (

        <div className="card">
        <div className="card__image">
           <div className="show_option">
                <div className="cover_option">
                    <i class="fa-solid fa-pen-to-square" title='modifier' onClick={()=>{updateBoutique(boutique.id)}}></i>
                    <i class="fa-sharp fa-solid fa-trash" onClick={()=>{DeleteBoutique(boutique.id)}} title='supprimer'></i>
                </div>
           </div>
        </div>
        <div className="card__copy" onClick={()=> {showBoutique(boutique.id)}}>
            <h1 className='card-name'>{boutique.nom}</h1>
            <span className='card-item-title'>Crée le : <span>{boutique.date_de_creation}</span></span>
            <span className='card-item-title'>En congé : <span>{ (boutique.en_conge) ? "oui" : "non"  }</span></span>
            <span className='card-item-title'>Horraires : </span>
            <table>
                {
                    boutique.horaires_de_ouverture.map( jourObjet => (
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

)
}

export default Boutique