import React, { useState } from 'react';
import { useHistory } from "react-router-dom";
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import Paper from '@mui/material/Paper';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import axios from 'axios';
import logo from "../images/logo.PNG";


const NavBar = (props) => {

  const [token,setToken] = useState(localStorage.getItem("token"));

  return (
    <div className="navbar">
        <img src={logo} alt="shop"  className="logo"/>
        <form onSubmit >
                <div className="search_input">
                        <i class="fas fa-search"></i>
                        <input type="text"  id="search_input" />
                </div>           
        </form>
        <div class="avatar-user"></div>
        <div className="pop-up-fav ">
                
            <span> 
                 Mon Profil
            </span>   
            <span > 
                 Se Déconecter
            </span>   
                    
        </div>
    </div>
  );
}
export default NavBar;