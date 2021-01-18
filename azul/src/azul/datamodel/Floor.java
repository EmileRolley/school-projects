package azul.datamodel;

import java.util.ArrayList;

public class Floor extends ContainerXList implements LimitedSize {

	Discard discard;

    public Floor(Discard discard) {
		this.discard = discard;
		containerList = new ArrayList<TileContainerX>( 7 );
		addEmptyContainers( 7 );
	}

    public boolean containsFirstPlayerTile() {
		for (TileContainerX containerX : containerList)
			if ( containerX.contains(Color.FIRST) )
				return( true );

        return( false );
	}
	
	public void add(ArrayList<Tile> tiles) {
		ArrayList<Tile> list;
		int nbTilesToAdd = getMaximalSizeX() - getNbOfFilledContainers(); 

		for (int i = 0; i < tiles.size() && i < nbTilesToAdd; i++) {
			list = new ArrayList<Tile>();
			list.add( tiles.get(i) );
			super.add( list );
		}
		discard.push(tiles);
	}

	// NOTE : could be smartter ?
    public int calcScore() {
		int length = getNbOfFilledContainers();

		switch( length ) {
			case 1 : return( -1 );
			case 2 : return( -2 );
			case 3 : return( -4 );
			case 4 : return( -6 );
			case 5 : return( -8 );
			case 6 : return( -11 );
			case 7 : return( -14 );
        	default : return( 0 );
		}
	}
	
	public ArrayList<Tile> drain() {
		ArrayList<Tile> tiles = get( Color.ALL );
		return( removeFirstPlayerTile(tiles) ); 
	}

	private ArrayList<Tile> removeFirstPlayerTile(ArrayList<Tile> tiles) {
		for (int i = 0; i < tiles.size(); ++i)
			if ( tiles.get(i).getColor().equals(Color.FIRST) ) {
				tiles.remove( i );
				return( tiles );
			}

		return( tiles );
	}

    public int getMaximalSizeX() {
        return( 7 );
    }

	@Override
	public String toString() {
		return( "Floor -> " + super.toString() ) ;
	}
	
	/** ------------------ TUI ------------------ */
	
	public String getFirstLine() {
		int width = getContentWidth();

		return( Print.completeWithCharTo("- Floor ", '-', width) );
	}

	public String getSecondLine() {
		return( getContentToString() );
	}

	public String getThirdLine() {
		return( "--[-1]---[-1]---[-2]---[-2]---[-2]---[-3]---[-3]--");
	}
}