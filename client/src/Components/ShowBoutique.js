import React,{useState,useEffect} from 'react'
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate  } from "react-router-dom";


const ShowBoutique = () => {

    const [api,setApi] = useState("http://localhost:8000/api");
    const [token,setToken] = useState(localStorage.getItem("token"));

        
    return (
       
        <div class="show_img show_me">
            <div class="img_header">
                <span class="close_img">
                    <i class="fas fa-times"> </i>
                    close
                </span>
                <span class="c_image">
                     2 / 30
                 </span>
                 <span class="">
                    <a class="d_full_img" href="" rel="nofollow" download="" target="_blank">
                         <i class="fas fa-download"></i>
                    </a>
                 </span>
            </div>
        </div>
    

)
}

export default ShowBoutique