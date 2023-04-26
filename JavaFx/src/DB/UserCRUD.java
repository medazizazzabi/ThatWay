/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package DB;

import Entities.User;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author Aziza
 */
public class UserCRUD implements EntityCRUD<User> {

    private final Connection cnx = DB.getInstance().getCnx();

    @Override
    public void addEntity(User u) {
        try {
            String req = "INSERT INTO `user` (`email`,`cin`,`last_name`,`first_name`,`address`,`phone`,`password`,`admin`) VALUES (?,?,?,?,?,?,?,?)";
            PreparedStatement ps = cnx.prepareStatement(req);
            ps.setString(1, u.getEmail());
            ps.setInt(2, u.getCin());
            ps.setString(3, u.getLast_name());
            ps.setString(4, u.getFirst_name());
            ps.setString(5, u.getAddress());
            ps.setInt(6, u.getPhone());
            ps.setString(7, u.getPassword());
            ps.setBoolean(8, u.isAdmin());
            ps.executeUpdate();
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

    @Override
    public void editEntity(User u) {
        try {
            String req = "UPDATE `user` SET `first_name` = '" + u.getFirst_name() +
                    "' , `last_name` = '" + u.getLast_name() +
                    "' , `adresse` = '" + u.getAddress() +
                    "' , `email` = '" + u.getEmail() +
                    "' , `cin` = '" + u.getCin() +
                    "' , `num_tel` = '" + u.getPhone() +
                    "' , `password` = '" + u.getPassword() +
                    "' , `admin` = '" + u.isAdmin() +
                    "' WHERE id = " + u.getId();
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("User updated !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

    @Override
    public void deleteEntity(User u) {
        try {
            String req = "DELETE FROM user WHERE id = " + u.getId();
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

    @Override
    public List<User> getEntities() {
        List<User> list = new ArrayList<>();
        try {
            String req = "Select * from user";
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
            while (rs.next()) {
                User u = new User();
                u.setId(rs.getInt("id"));
                u.setFirst_name(rs.getString("first_name"));
                u.setLast_name(rs.getString("last_name"));
                u.setAddress(rs.getString("address"));
                u.setEmail(rs.getString("email"));
                u.setCin(rs.getInt("cin"));
                u.setPhone(rs.getInt("phone"));
                u.setPassword(rs.getString("password"));
                u.setAdmin(rs.getBoolean("admin"));
                list.add(u);
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return list;
    }

    public User getUserById(int id){
        User u = new User();
        try {
            String req = "Select * from user where id = " + id;
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
            while (rs.next()) {
                u.setId(rs.getInt("id"));
                u.setFirst_name(rs.getString("first_name"));
                u.setLast_name(rs.getString("last_name"));
                u.setAddress(rs.getString("address"));
                u.setEmail(rs.getString("email"));
                u.setCin(rs.getInt("cin"));
                u.setPhone(rs.getInt("phone"));
                u.setPassword(rs.getString("password"));
                u.setAdmin(rs.getBoolean("admin"));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return u;
    }

    public User getUserByEmail(String email){
        User u = new User();
        try {
            String req = "Select * from user where email = '" + email + "'";
            Statement st = cnx.createStatement();
            ResultSet rs = st.executeQuery(req);
            while (rs.next()) {
                u.setId(rs.getInt("id"));
                u.setFirst_name(rs.getString("first_name"));
                u.setLast_name(rs.getString("last_name"));
                u.setAddress(rs.getString("address"));
                u.setEmail(rs.getString("email"));
                u.setCin(rs.getInt("cin"));
                u.setPhone(rs.getInt("phone"));
                u.setPassword(rs.getString("password"));
                u.setAdmin(rs.getBoolean("admin"));
            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
        return u;
    }
}
