package azul.datamodel;

public class Center extends ContainerXList {

	public Center() {}

	public void addFirstPlayerTile() {
		add( new Tile(Color.FIRST) ); 
	}

	public Tile getFirstPlayerTile() {
		TileContainerX container = getTileContainerXAt(0);

		if ( !container.isEmpty() && container.contains(Color.FIRST) )
			return container.getTile();

		return null;
	}

	public boolean isEmpty() {
		for (TileContainerX container : containerList) {
			if ( !container.isEmpty() )
				return false;
		}
		return true;
	}

	@Override
	public String toString() {
		String firstLine, secondLine, thirdLine;
		int contentWidth; 

		secondLine = getContentToString();
		contentWidth = getContentWidth();
		thirdLine = Print.completeWithCharTo( "", '-', contentWidth );
		firstLine = Print.completeWithCharTo( "- Center ", '-', contentWidth );
	
		return( "|  " + stretch(firstLine, false) + "|\n"
				+ "|  " + stretch(secondLine, true) + "|\n"
				+ "|  " + stretch(thirdLine, false) + "|" );
	}

	private String stretch(String str, boolean withCode) {
		int width = Print.MAX_WIDTH;

		if ( withCode )
			width += str.length() - getContentWidth();
		return( Print.completeWithCharTo(str, ' ', width - 4) );
	}
}