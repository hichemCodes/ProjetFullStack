import { useState } from 'react';
import ReactDOM from 'react-dom/client';
import axios from "axios";
import { Link } from 'react-router-dom';
import '../styles/AppAfterLogIn.css';
import logo from "../images/shop.png";
import img from "../images/global-ecommerce-market-removebg-preview.png"
import Button from '@mui/material/Button';


const Home = ()=> {
  return (
     

    <div class="container-fluid container-fluid-update px-0 px-md-5 mb-5">
      <div className="mini-nav">
          
          <div className="nav_interactoin">
            <Link to="/login">
              <Button variant="text">Se Connecter</Button>
            </Link>
            <Link to="/register">
              <Button variant="text">S'inscrire</Button>
            </Link>
          </div>
      </div>
      
      <div class="row align-items-center px-3">
        <div class="col-lg-6 text-center text-lg-left">
            <h4 class="text-white mb-4 mt-5 mt-lg-0">Soyez les bienvenues</h4>
          <h1 class="display-3 font-weight-bold text-white">
            MyShop
          </h1>
          <p class="text-white mb-4">
            Soyez les bienvenues Soyez les bienvenuesSoyez les bienvenuesSoyez les bienvenues
            Soyez les bienvenuesSoyez les bienv
            enuesSoyez les bienvenues

            </p>
            <a href="" class="btn btn-secondary mt-1 py-3 px-5">Visiter nos Boutiques !</a>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
          <img class="img-fluid mt-5" src={img} alt="" />
        </div>
      </div>
    </div>
  )
}

export default Home;
