import React from "react";
import Swal from 'sweetalert2';
import axios from 'axios';
import { useNavigate  } from "react-router-dom";



const ReadOnlyRowUser = ({user,api,token,getAllUsers}) => {
  

  const deleteUser = (id) => {
    Swal.fire({
        title: 'Est-ce que vous êtes sûr de vouloir supprimer cet utilisateur',
        showCancelButton: true,
        confirmButtonText: 'Supprimer',
        cancelButtonText: "Annuler",
      }).then((result) => {
        if (result.isConfirmed) {
              Swal.fire('Utilisateur supprimé avec succès !', '', 'success');
              axios.delete(`${api}/users/${id}`,{ headers: {"Authorization" : `Bearer ${token}`} }).then(
                  response => {
                        if( response.status === 200) {
                          getAllUsers();
                        }
                  }
              )
        } 
      })
}

  return (
    <tr>
      <td className="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <div className="flex">
          <div className="flex-shrink-0 w-10 h-10">
            <img className="w-full h-full rounded-full"  alt="" />
          </div>
          <div className="ml-3">
            <p className="text-gray-900 whitespace-no-wrap">
              {user.prenom} {user.nom}"
            </p>
          </div>
        </div>
      </td>
      <td className="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <div className="flex">
          <div className="flex-shrink-0 w-10 h-10">
            <img className="w-full h-full rounded-full"  alt="" />
          </div>
          <div className="ml-3">
            
            <p className="text-gray-600 whitespace-no-wrap">{user.email}</p>
          </div>
        </div>
      </td>
      <td className="px-5 py-5 border-b border-gray-200 bg-white text-sm">
        <p className="text-gray-900 whitespace-no-wrap">
           {user.roles[0]}
        </p>
      </td>
  
      <td className="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
        <i class="fa-sharp fa-solid fa-trash delete-user" onClick={()=>{deleteUser(user.id)}} title='supprimer'></i>
        <i class="fa-sharp fa-solid fa-pen edit-user" title='modifier'></i>
      </td>
    </tr>
  );
};

export default ReadOnlyRowUser;