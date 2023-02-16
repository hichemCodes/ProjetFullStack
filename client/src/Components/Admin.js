import React, { useState,useEffect, useRef } from 'react';
import axios from 'axios';
import NavBar from "./NavBar";
import Loader from "./loader";
import Categorie from './Categorie';
import SwitchPages from './SwitchPages';
import AllPages from './AllPages';
import '../styles/App.css';
import '../styles/AppAfterLogIn.css';
import '../styles/produits.css';
import UpdateCategorie from './UpdateCategorie';
import AssignerProduitsToCategorie from './AssignerProduitsToCategorie';
import { Navigate } from 'react-router-dom';
import ReadOnlyRowUser from './ReadOnlyRowUser';
import { GlobalStyle } from '../styles/global/global';



const Admin = ({token,api,config,change_current_page,currentPageSwitch,changeCurrentShowData}) => {

 
  const [users,setUsers] = useState([]);
  const [query,setQuery] = useState('');
  const [current_action,setCurrentAction] = useState("Tout les utilisateurs");
  const [user,setUser] = useState([]);
  const [userRole,setUserRole] = useState([]);
 
  

  const getAllUsers = () => {
     

      axios.get(`${api}/users`,{ headers: {"Authorization" : `Bearer ${token}`} }).then(
        response => {
            if( response.status === 200) {
              setUsers(response.data);
              console.log(users);
            }
        }
      )
  }

  const getCurrentUser = ()=> {
    const datas = {};
    axios.get(`${api}/users/me`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
      response => {
          if( response.status === 200) {
            setUser(response.data[0]);
            setUser(response.data[0]);
            setUserRole(response.data[0].roles[0])
          }
      }
    )
  }




  useEffect( () =>{
    change_current_page("administrateur");
    getCurrentUser();
    getAllUsers();
    if(userRole == "ROLE_ADMIN") {
        Navigate("/Forbidden")
    }
    
  },[]);


  return ( 
    <React.Fragment>
        
        <NavBar
            query = {query}
            change_query = {(new_query)=> { setQuery(new_query)}}
            user = {user}
        />
        
        <span id="current_action" className='current_action_custum'>{current_action} { (query != "") ? `(recherche : ${query} )` : ""}</span>
        
        <div className="choices choices_categories">
            <SwitchPages 
                change_current_page={change_current_page}
                currentPageSwitch={currentPageSwitch}
                api={api}
                token={token}
            />
        </div>
        
        
        <div className="container admin-container">
        <div className="">
       
          <div className="   py-4 overflow-x-auto">
            <div className="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
              <table className="min-w-full leading-normal admin-table">
                <thead>
                  <tr>
                    <th className="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Utilisateur
                    </th>
                    <th className="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Email
                    </th>
                    <th className="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Role
                    </th>
                    <th className="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                      Actions
                    </th>
                    <th className="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
                  </tr>
                </thead>
                <tbody>
                {users.map((user) => {
                    return (
                      <>
                       
                          <ReadOnlyRowUser
                             user={user}
                             getAllUsers={getAllUsers}
                             api={api}
                             token={token}
                          />
                        
                      </>
                    );
                  })}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </React.Fragment>
  );
}
export default Admin;