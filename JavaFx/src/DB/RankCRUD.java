/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package DB;

/**
 *
 * @author khiar
 */

import Entities.Rank;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author khiar
 */
public class RankCRUD implements EntityCRUD<Rank> {

    private final Connection connection = DB.getInstance().getCnx();

    @Override
    public void addEntity(Rank r) {
        String query = "INSERT INTO ranks (nom, prix) VALUES (?, ?)";
        try {
            PreparedStatement statement = connection.prepareStatement(query);
            statement.setString(1, r.getNom());
            statement.setFloat(2, r.getPrix());
            statement.executeUpdate();
            statement.close();
        } catch (SQLException e) {
            System.out.println(e.toString());
        }
    }

    @Override
    public void editEntity(Rank r) {
        String query = "UPDATE ranks SET nom = ?, prix = ? WHERE id = ?";
        try {
            PreparedStatement statement = connection.prepareStatement(query);
            statement.setFloat(2, r.getPrix());
            statement.setString(1, r.getNom());
            statement.setInt(3, r.getId());
            statement.executeUpdate();
        } catch (SQLException e) {
            System.out.println(e.toString());
        }
    }

    @Override
    public void deleteEntity(Rank r) {
        String query = "DELETE FROM rank WHERE id = ?";
        try {
            PreparedStatement statement = connection.prepareStatement(query);
            statement.setInt(1, r.getId());
            statement.executeUpdate();
            statement.close();
        } catch (SQLException e) {
            System.out.println(e.toString());
        }
    }

    @Override
    public List<Rank> getEntities() {
        String query = "SELECT * FROM ranks";
        List<Rank> ranks = new ArrayList<>();
        try {
            Statement statement = connection.createStatement();
            ResultSet resultSet = statement.executeQuery(query);
            while (resultSet.next()) {
                Rank r = new Rank();
                r.setId(resultSet.getInt("id"));
                r.setNom(resultSet.getString("nom"));
                r.setPrix(resultSet.getFloat("prix"));
                ranks.add(r);
            }

        } catch (SQLException e) {
            System.out.println(e.toString());
        }
        return ranks;
    }

    public Rank getRankByID(int id) {
        Rank r = new Rank();
        String query = "SELECT * FROM ranks WHERE id = ?";
        try {
            PreparedStatement statement = connection.prepareStatement(query);
            statement.setInt(1, id);
            ResultSet resultSet = statement.executeQuery();
            if (resultSet.next()) {
                r.setId(resultSet.getInt("id"));
                r.setNom(resultSet.getString("nom"));
                r.setPrix(resultSet.getFloat("prix"));
            }
        } catch (SQLException e) {
            System.out.println(e.toString());
        }
        return r;
    }
}
