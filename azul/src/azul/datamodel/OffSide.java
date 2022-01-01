package azul.datamodel;

public class OffSide {

	private Bag bag;
    private Discard discard;

    public OffSide(String variant) {
        bag = new Bag( variant );
        discard = new Discard();
    }

    public Bag getBag() {
		return bag;
	} 

    public Discard getDiscard() {
        return discard;
    }

    public boolean bagIsEmpty() {
        return bag.isEmpty();
	}

    public boolean refillBag() {
        if ( discard.isEmpty() )
            return false;

        bag.pushAndShuffle( discard.drain() );

        return true;
    }
}