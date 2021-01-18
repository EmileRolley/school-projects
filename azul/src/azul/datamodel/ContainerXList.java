package azul.datamodel;

import java.util.ArrayList;

public abstract class ContainerXList {
	
	protected ArrayList<TileContainerX> containerList;
	protected int tail;

    public ContainerXList() {
		this( 0 );
	}
	
	public ContainerXList(int size) {
		tail = 0;
		containerList = new ArrayList<TileContainerX>( size );
		addEmptyContainers( size );
	}

	@Override
	public String toString() {
		String res = "[\n";

		for (TileContainerX container : containerList)
			res += container.toString() + ",\n";

		return( res + "]" );
	}

    public boolean isEmpty() {
        return( containerList.isEmpty() );
	}
	
	/** NOTE : used only in debugging. */
	public int size() {
		return( containerList.size() );
	}

	public int getNbOfFilledContainers() {
		int size = 0;

		for (TileContainerX container : containerList)
			if ( !container.isEmpty() )
				++size;

		return( size );
	}

	protected void addEmptyContainers(int nbContainers) {
		while ( nbContainers-- > 0 )
			containerList.add( new TileContainerX(tail++, null, this) );
	}
	
	/** tiles size is supposed to be managed by the calling method. */
    public void add(ArrayList<Tile> tiles) {
		fillEmptyContainers( tiles );
		if ( !tiles.isEmpty() ) {
			addEmptyContainers( tiles.size() );
			add( tiles );
		}
	}

	public void add(Tile tile) {
		ArrayList<Tile> tmp = new ArrayList<Tile>( 1 );
		
		tmp.add(tile);
		add( tmp );	
	}

	private void fillEmptyContainers(ArrayList<Tile> tiles) {
		int index = 0;

		for (TileContainerX container : containerList) {
			if ( container.isEmpty() && index < tiles.size() ) {
				container.setTile( tiles.get(index) );
				tiles.remove( index );
			}
		}
	}
	
    public ArrayList<Tile> get(Color color) {
		ArrayList<Tile> collectedTiles = new ArrayList<Tile>();

		for (TileContainerX container : containerList)
			if ( container.contains(color) )
				collectedTiles.add( container.getTile() );

        return( collectedTiles );
	}
	
	public TileContainerX getTileContainerXAt(int xPos) {
		for (TileContainerX container : containerList)
			if ( container.getXPos() == xPos )
				return( container );

		return( new TileContainerX() );
	} 

	public TileContainerXY getTileContainerXYAt(int x, int y) {
		return( new TileContainerXY() );
	}
	
	/** ------------------ TUI ------------------ */

	/** NOTE : affiche les tile container vide avec '.....' */
	protected String getContentToString() {
		String res = "|";
		int len = containerList.size();

		for (int i = 0; i < len-1; ++i)
			res += containerList.get(i).toString(this) + " ";
		if ( len > 0 )
			res += containerList.get(len-1).toString(this);
		
		return( res + "|" );
	}
	
	protected int getContentWidth() {
		int nbColors = containerList.size();
		return( nbColors * Color.MAX_NAME_LENGTH + nbColors + 1 );
	}
}