package azul.datamodel;

import java.util.ArrayList;
import java.util.Collections;

public class Bag extends TileStack {
	
	public static ArrayList<Tile> createTiles(int nb, Color color) {
		ArrayList<Tile> tiles = new ArrayList<Tile>( nb );

		for (int i = 0; i < nb; ++i)
			tiles.add( new Tile(color) );
		
		return( tiles );
	}
	
	public Bag(String variant) {
		switch ( variant ) {
			default : initializeClassic(); break;
		}
	}

	private void initializeClassic() {
		push( Bag.createTiles(20, Color.BLUE) );				
		push( Bag.createTiles(20, Color.YELLOW) );				
		push( Bag.createTiles(20, Color.RED) );				
		push( Bag.createTiles(20, Color.PURPLE) );				
		push( Bag.createTiles(20, Color.WHITE) );
		shuffle();
	}

	public void pushAndShuffle(ArrayList<Tile> tiles) {
		push( tiles );
		shuffle();
	}

	private void shuffle() {
		Collections.shuffle( tilesStack );
  }

	@Override
	public String toString() {
		String res = "[\n";

		for (Tile tile : tilesStack)
			res += tile + ",\n"; 
		return( "Bag -> " + res + "]" );
	}
	
	public ArrayList<Tile> pick(int n) {
		ArrayList<Tile> tiles = new ArrayList<Tile>( n );

		while ( n-- > 0 )
			if ( !tilesStack.isEmpty() )
				tiles.add( tilesStack.pop() );
		
		return( tiles );
	}
}
