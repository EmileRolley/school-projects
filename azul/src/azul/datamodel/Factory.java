package azul.datamodel;

import java.util.ArrayList;

public class Factory extends ContainerXList implements LimitedSize {

	private final int id;

    public Factory(int id) {
		this.id = id;
		containerList = new ArrayList<TileContainerX>( getMaximalSizeX() );
		addEmptyContainers( getMaximalSizeX() );
    }

    public int getMaximalSizeX() {
		return( 4 );
	}

	public int getId() {
		return( id );
	}

	/**
	 * @param nbPlayers
	 * @return -1 if the number of player is incorrect
	 */
	public static int getNumberOfFactories(int nbPlayers) {
		switch( nbPlayers ) {
			case 2: return 5;
			case 3: return 7;
			case 4: return 9;
			default: return -1;
		}
	}

	public boolean isEmpty() {
		for (TileContainerX container : containerList) {
			if (!container.isEmpty())
				return false;
		}

		return true;
	}

	@Override
	public String toString() {
		return( "Factory" + id + " -> " + super.toString() );
	}
	
	/**
	 * NOTE : should returns false or throws an exception
	 * when there is not enough space ?
	 */
	@Override
	public void add(ArrayList<Tile> tiles) {
		if ( thereIsEnoughSpaceFor(tiles) )	
			super.add( tiles );
	}

	private boolean thereIsEnoughSpaceFor(ArrayList<Tile> tiles) {
		int nbOfFilledContainers = super.getNbOfFilledContainers();
		int maxSize = getMaximalSizeX(); 

		return( nbOfFilledContainers + tiles.size() <= maxSize );
	}

	/** ------------------ TUI ------------------ */
	
	public String getFirstLine() {
		return( "------------- " + id + " -------------" );
	}

	public String getSecondLine() {
		return( getContentToString() );
	}

	public String getThirdLine() {
		return( "-----------------------------" );
	}
}