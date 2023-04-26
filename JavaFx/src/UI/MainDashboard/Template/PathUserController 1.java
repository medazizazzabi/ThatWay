/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package UI.MainDashboard.Template;

import UI.MainDashboard.PathUser.*;
import Entities.User;
import UI.MainDashboard.*;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.layout.AnchorPane;
import javafx.event.ActionEvent;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.HBox;

/**
 * FXML Controller class
 *
 * @author Aziza
 */
public class PathUserController implements Initializable {

    @FXML
    private AnchorPane mainPane;
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
    private HBox complaint;
    @FXML
    private TextField Location;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        System.out.println(User.getCurrent_user().isAdmin());
        if (User.getCurrent_user().isAdmin()) {
            adminbtn.setOpacity(0);
        }

    }

    @FXML
    private void homeClicked(MouseEvent event) {
    }

    @FXML
    private void subscriptionClicked(MouseEvent event) {
    }

    @FXML
    private void stationCLicked(MouseEvent event) {
    }

    @FXML
    private void pathClicked(ActionEvent event) {
    }

    @FXML
    private void vehiuculeClicked(ActionEvent event) {
    }

    @FXML
    private void adminClicked(ActionEvent event) {
    }

    @FXML
    private void complaintClicked(MouseEvent event) {
    }

}
