/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Entities;

/**
 *
 * @author khiar
 */
import java.sql.Date;


/**
 *
 * @author khiar
 */
public class Abonnement {
    private int idAbonnement;
    private int idClient;
    private Date dateDebut;
    private int DureeAbonnement;
    private Rank rankAbonnement;

    public Abonnement(int idClient, Date dateDebut, int DureeAbonnement, float prix, Rank rankAbonnement) {
        this.idClient = idClient;
        this.dateDebut = dateDebut;
        this.DureeAbonnement = DureeAbonnement;
        this.rankAbonnement = rankAbonnement;
    }

    public Abonnement() {
    }

    public int getIdAbonnement() {
        return idAbonnement;
    }

    public void setIdAbonnement(int idAbonnement) {
        this.idAbonnement = idAbonnement;
    }

    public int getIdClient() {
        return idClient;
    }

    public void setIdClient(int idClient) {
        this.idClient = idClient;
    }

    public Date getDateDebut() {
        return dateDebut;
    }

    public void setDateDebut(Date dateDebut) {
        this.dateDebut = dateDebut;
    }

    public int getDureeAbonnement() {
        return DureeAbonnement;
    }

    public void setDureeAbonnement(int DureeAbonnement) {
        this.DureeAbonnement = DureeAbonnement;
    }

    public Rank getrankAbonnement() {
        return rankAbonnement;
    }

    public void setrankAbonnement(Rank rankAbonnement) {
        this.rankAbonnement = rankAbonnement;
    }


}
