package azul.datamodel;

import java.util.Stack;
import java.util.ArrayList;

public abstract class TileStack {

	protected Stack<Tile> tilesStack;

	public TileStack() {
		tilesStack = new Stack<Tile>();
	}
	
	public void push(ArrayList<Tile> tiles) {
		for (Tile tile : tiles)
			tilesStack.push( tile );
	}

	public void push(Tile tile) {
		tilesStack.push( tile );
	}

    public Tile pick() {
		return( tilesStack.pop() );
	}
	
	public void empty() {
		tilesStack = new Stack<Tile>();
	}

	public boolean isEmpty() {
		return( tilesStack.isEmpty() );
	}
	
	public ArrayList<Tile> drain() {
		ArrayList<Tile> tiles = new ArrayList<Tile>();

		while ( !tilesStack.isEmpty() )
			tiles.add( tilesStack.pop() );

		return( tiles );
	} 
}