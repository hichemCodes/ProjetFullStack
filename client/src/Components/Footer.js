import React from 'react'
import footer_logo from "../images/logo-univ-rouen-normandie.png"
const Footer =() =>{
    return (
        <div className="fotter">
                <div className="a-git">
                <i class="fab fa-github"></i>
                      <a href="https://github.com/hichemCodes/ProjetFullStack" target="_blanck"
                              >Projet disponible sur github
                      </a>
                </div>
                <div className="licences">
                      <span>
                          Conçu et développé par : 
                          <a href="https://github.com/hichemCodes" target="_blanck">LAOUAR Hichem</a>
                          <strong> & </strong>
                          <a href="https://github.com/iliesBouk" target="_blanck">BOUKTAYA Ilies</a>

                      </span>
                </div>
                <div className="powred_by"> 
                      <img src={footer_logo} className='footer_logo' alt="shop"/>
                      <span>Ce projet il a été créé dans le cadre d'un projet universitaire</span>
                </div>
        </div>
    )
}

export default Footer