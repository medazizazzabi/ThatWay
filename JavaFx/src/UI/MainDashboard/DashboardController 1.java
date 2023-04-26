/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package UI.MainDashboard;

import Entities.User;
import UI.SplashScreen.SplashScreenController;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.layout.AnchorPane;
import javafx.event.ActionEvent;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.HBox;
import javafx.scene.paint.Color;
import javafx.scene.web.WebView;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author Aziza
 */
public class DashboardController implements Initializable {

    @FXML
    private HBox home;
    @FXML
    private HBox suscription;
    @FXML
    private Label stationbtn;
    @FXML
    private Button pathbtn;
    @FXML
    private Button Vehicule;
    @FXML
    private Button adminbtn;
    @FXML
    private HBox suscription1;
    @FXML
    private WebView mapView;
   

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        Vehicule.setOpacity(0);
        if (!User.getCurrent_user().isAdmin()) {
            adminbtn.setOpacity(0);
        }
        
        mapView.getEngine().load("https://maps.google.com");

    }

    @FXML
    private void homeClicked(ActionEvent event) {
    }

    @FXML
    private void subscriptionClicked(ActionEvent event) {
        Parent root = null;
        try {
            root = FXMLLoader.load(getClass().getResource("Subscription/User.fxml"));
        } catch (IOException ex) {
            Logger.getLogger(SplashScreenController.class.getName()).log(Level.SEVERE, null, ex);
        }

        Scene scene = new Scene(root);
        Stage stage = new Stage();
        stage.setScene(scene);
        stage.show();

        stationbtn.getScene().getWindow().hide();
    }

    @FXML
    private void ComplaintClicked(ActionEvent event) {
        Parent root = null;
        try {
            root = FXMLLoader.load(getClass().getResource("Complaint/complaint.fxml"));
        } catch (IOException ex) {
            Logger.getLogger(SplashScreenController.class.getName()).log(Level.SEVERE, null, ex);
        }

        Scene scene = new Scene(root);
        Stage stage = new Stage();
        stage.setScene(scene);
        stage.show();

        stationbtn.getScene().getWindow().hide();
    }

    @FXML
    private void pathClicked(ActionEvent event) {
        Parent root = null;
        try {
            root = FXMLLoader.load(getClass().getResource("PathUser/PathUser.fxml"));
        } catch (IOException ex) {
            Logger.getLogger(SplashScreenController.class.getName()).log(Level.SEVERE, null, ex);
        }

        Scene scene = new Scene(root);
        Stage stage = new Stage();
        stage.setScene(scene);
        stage.show();

        stationbtn.getScene().getWindow().hide();
    }

    @FXML
    private void vehiuculeClicked(ActionEvent event) {

    }

    @FXML
    private void adminClicked(ActionEvent event) {
        Parent root = null;
        try {
            root = FXMLLoader.load(getClass().getResource("Admin/FXML.fxml"));
        } catch (IOException ex) {
            Logger.getLogger(SplashScreenController.class.getName()).log(Level.SEVERE, null, ex);
        }

        Scene scene = new Scene(root);
        Stage stage = new Stage();
        stage.setScene(scene);
        stage.show();

        stationbtn.getScene().getWindow().hide();
    }

    @FXML
    private void StationClicked(ActionEvent event) {
        Parent root = null;
        try {
            root = FXMLLoader.load(getClass().getResource("Station/Dashboard.fxml"));
        } catch (IOException ex) {
            Logger.getLogger(SplashScreenController.class.getName()).log(Level.SEVERE, null, ex);
        }

        Scene scene = new Scene(root);
        Stage stage = new Stage();
        stage.setScene(scene);
        stage.show();

        stationbtn.getScene().getWindow().hide();
    }

}
