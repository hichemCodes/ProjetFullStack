import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate  } from "react-router-dom";


const ShowBoutique = () => {

    const [api,setApi] = useState("http://localhost:8000/api");
    const [token,setToken] = useState(localStorage.getItem("token"));
    const config = {
        headers: { 
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    };

    useEffect( () =>{
       
        axios.get(`${api}/boutiques/${id}/produits`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
            response => {
                if( response.status === 200) {
                  setAllpages(Math.ceil((response.data.length) / per_page))
                  setBoutiques(response.data);
                  setIsloading(false);
                }
            }
        );



    },[]);
    
        
    return (
       
        <div class="show_img show_me">
            <div class="img_header">
                <span class="close_img">
                    <i class="fa-solid fa-backward-step"></i>
                    Retour
                </span>
            </div>
            <h1>Boutique :</h1>
        </div>
    

)
}

export default ShowBoutique