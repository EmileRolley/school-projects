package azul.datamodel;

import java.util.ArrayList;

public class PatternLines extends ContainerXYList implements LimitedSize {

    public PatternLines() {
		super( 5, 5 );
		removeExcessContainers();
	}

	private void removeExcessContainers() {
		TileContainerXY containerXY;

		for (int i = 0; i < containerList.size(); ++i) {
			containerXY = (TileContainerXY) containerList.get( i );
			if ( containerXY.getXPos() > containerXY.getYPos() )
				containerList.remove( i-- );
		}
	}

	public ArrayList<TileContainerXY> getLineAt(int line) {
		if (line < 0 || line >= getMaximalSizeY())
			return null;

		ArrayList<TileContainerXY> list = new ArrayList<TileContainerXY>();

		for (int column = 0; column < getMaximalSizeX(line); column++) {
			list.add(getTileContainerXYAt(column, line));
		}

		return list;
	}

	public boolean contains(ArrayList<TileContainerXY> line, Color color) {
		for (TileContainerXY container : line) {
			if (container.contains(color))
				return true;
		}

		return false;
	}

	public boolean isLineEmpty(ArrayList<TileContainerXY> line) {
		for (TileContainerXY container : line) {
			if (!container.isEmpty())
				return false;
		}

		return true;
	}

	public boolean isLineFull(ArrayList<TileContainerXY> line) {
		for (TileContainerXY container : line) {
			if (container.isEmpty())
				return false;
		}

		return true;
	}

	public ArrayList<Tile> add(ArrayList<TileContainerXY> line, ArrayList<Tile> tiles) {
		for (int i = 0; i < line.size() && !tiles.isEmpty(); i++) {
			TileContainerXY container = line.get(i);
			if (container.isEmpty()) {
				container.setTile(tiles.remove(0));				
			}
		}
		
		return tiles;
	}

	public int getMaximalSizeX() {
		return( 5 );
	}

	public int getMaximalSizeX(int linePos) {
		return( linePos + 1 );
	}
	
	public int getMaximalSizeY() {
		return( 5 );
	}

	@Override
	public String toString() {
		return( "PatternLines -> " + super.toString() );
	}
	
	/** ------------------ TUI ------------------ */

	public String[] getLinesToString() {
		String[] lines = new String[7];
		String[] content = getContentToStringTab( getMaximalSizeX(), false );
		
		lines[0] = Print.completeWithCharTo( "- Pattern ", '-', 36 );
		for (int i = 0; i < content.length; ++i) lines[i+1] = content[i];
		lines[6] = Print.getNMinusChar( 36 );

		return( lines );
	}
}