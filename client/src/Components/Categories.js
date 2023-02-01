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




const Categories = ({user,token,api,config,change_current_page,currentPageSwitch,changeCurrentShowData}) => {

 
  const [query,setQuery] = useState('');
  const [is_loading,setIsloading] = useState(true);
  const [page,setPage] = useState(1);
  const [offset,setOffest] = useState(0);
  const [per_page,setPerpage] = useState(10);
  const [all_pages,setAllpages] = useState(1);
  const [current_action,setCurrentAction] = useState("Toutes les categories");
  const [operation,setOperation] = useState("add");
  const [categories,setCategories] = useState([]);
  const [categorieUpdate,setCategorieUpdate] = useState([]);
  const [allProduitsToCategorie,setAllProduitsToCategorie] = useState([]);
  const [allProduitsNotBelongToThisCategorie,setAllProduitsNotBelongToThisCategorie] = useState([]);


  const getAllCategorie = () => {

      setOffest(per_page * (page - 1));

      const datas = {
        "limit" : per_page,
        "offset" : per_page * (page - 1),//a construire
      };

      
      if(query != "") {
        datas.query = query;
      }

      axios.get(`${api}/categories`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
        response => {
            if( response.status === 200) {
              setCategories(response.data[0]);
              setIsloading(false);
              setAllpages(Math.ceil((response.data[1].allPages) / per_page));
            }
        }
      )
  }

  const UpdateCategorieAdd = (operation)=> {
    setOperation("add");
    setCategorieUpdate([]);
    document.querySelector(".pop-up-update-add").classList.toggle('show_me');
    document.querySelector(".cover_add").classList.toggle('fade');
  }


  const getAllProduitsToAssignCategorie = () => {

    const datas = {
      "limit" : 150,
      "offset" : 0
    };

    axios.get(`${api}/produits`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
      response => {
          if( response.status === 200) {
            setAllProduitsToCategorie(response.data[0]);
          }
      }
    )
  }

  useEffect( () =>{
    setIsloading(true);
    getAllCategorie();
  },[page,query]);


  useEffect( () =>{
    change_current_page("categories");
    getAllProduitsToAssignCategorie();
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
            />
            <AllPages 
                current_page = {page} 
                all_pages = {all_pages} 
                get_page = { (new_page)=> { setPage(new_page)}}
            />
            <span className="current_order c_item add_boutique" onClick = {() => {UpdateCategorieAdd("add")}}> <strong>Ajouter</strong> </span>

        </div>
        
        
        {
          (is_loading) ? (<Loader/>) 
          : 
            <div className="imgs boutiques produits">
                 { 
                categories.map( (categorie) =>  (
                    <Categorie
                        api = {api}
                        token = {token}
                        categorie = {categorie}
                        getAllCategorie = {getAllCategorie}
                        categories = {categories}
                        changeOperation = {(new_operation)=> {setOperation(new_operation)}}
                        changeCtegorieUpdate = {(new_value)=> {setCategorieUpdate(new_value)}}  
                        changeAllProduitsNotBelongToThisCategorie = {(new_value) => { setAllProduitsNotBelongToThisCategorie(new_value)} }                      
                        changeCurrentShowData = {changeCurrentShowData}
                    />
                  
                  ))
                }
            </div>
        }
        <div className="cover_add fade"></div>
        <UpdateCategorie
            operation={operation}
            categorieUpdate = {categorieUpdate}
            token = {token}
            api = {api}
            getAllCategorie = {getAllCategorie}
            changeOperation = {(new_operation)=> {setOperation(new_operation)}}
          />
            <AssignerProduitsToCategorie
              api = {api}
              token = {token}
              allProduitsToCategorie = {allProduitsToCategorie}
              allProduitsNotBelongToThisCategorie = {allProduitsNotBelongToThisCategorie}// a changé apres
              getAllCategorie = {getAllCategorie}
          />
    
    </React.Fragment>
  );
}
export default Categories;