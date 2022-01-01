package azul;

import azul.datamodel.*;

import java.util.Scanner;
import java.util.function.Function;
import java.util.function.Predicate;

public class Launcher {

	private static Scanner scan = new Scanner( System.in );
	public static void main(String[] args) {
		Game game = null;// new Game();
		
		/**
		 * TODO : Lancer la GUI si graphicalMode == true.
		 * TODO : Le prendre en compte dans Game.
		 */
		boolean graphicalMode = graphicalMode();

		game = initGame();
		game.play();
		
		scan.close();
	}

	private static boolean graphicalMode() {
		String res = askPlayer(
						"--- Souhaitez vous lancer Azul en mode graphique ? (o/n) ---",
						( str ) -> {
							return(
								str.compareTo("o") != 0 && str.compareTo("n") != 0
							);
						}
					);

		return( res.compareTo("o") == 0 );	
	}

	private static String askPlayer(String question, Predicate<String> predicate) {
		String res = "";

		do {
			System.out.println( question );
			if ( scan.hasNext() ) 
				res = scan.next();
		} while ( predicate.test(res) );

		return res;
	}

	private static Game initGame() {
		int nbPlayers = getNbPlayers();

		/** A terme la variante sera une enum. */
		String variant = getVariant();

		return( new Game(nbPlayers, variant) );
	}

	private static int getNbPlayers() {
		String res = askPlayer(
						"--- Combien êtes vous à jouer ? (2,3,4) ---",
						( str ) -> {
							return(
								str.compareTo("2") != 0
								&& str.compareTo("3") != 0
								&& str.compareTo("4") != 0
							);
						}
					); 

		return( Integer.valueOf(res) );	
	}

	private static String getVariant() {
		//? Rajouter une description plus détaillé des variantes ?
		String res = askPlayer(
						"--- Veuillez séléctionner une variante : ---\n"
						+ "\t(1) Classique\n"
						+ "\t(2) Mur incolore\n"
						+ "\t(3) Tuiles joker",
						( str ) -> {
							return(
								str.compareTo("1") != 0
								&& str.compareTo("2") != 0
								&& str.compareTo("3") != 0
							);
						}
					);

		switch ( res ) {
			case "1" : return( "Classic" );
			case "2" : return( "Uncolored" );
			default : return( "Joker" );
		}
	}
}