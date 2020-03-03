import Head from 'next/head'
import Header from '../components/Header'
import { Flex, Text } from '@chakra-ui/core'
import Footer from '../components/Footer'

const AVPage = () => (
    <>
        <Head>
            <title>Algemene Voorwaarden</title>
        </Head>

        <Flex direction='column' minHeight='100vh' justifyContent='space-between'>
            <Header />


            <Flex direction='column' width={['100%', '100%', '100%', '992px']} mx='auto'>
                <Text fontSize='xl' fontWeight='bold'>
                    Algemene Voorwaarden
                </Text>

                <Text fontSize='md'>
                    Deze algemene voorwaarden zijn van toepassing op alle aanbiedingen en bestellingen van digitale producten die te koop worden aangeboden op Multiversum.snoozing.dev. Het plaatsen van een bestelling via de website van Multiversum houdt in dat u deze algemene verkoopvoorwaarden aanvaardt.<br/>
                </Text>

                <Text fontSize='lg' mt='15px' fontWeight='bold'>
                    1 Aanbiedingen, prijzen en betalingen <br/>
                </Text>

                <Text fontSize='md'>
                    1.1 De vermelde prijzen voor de aangeboden producten en diensten zijn in euro’s en inclusief 21% BTW.<br/><br/>

                    1.3 De betaling van de aangeboden digitale producten op Multiversum.snoozing.dev geschiedt online en via de aangeboden betaalmethodes. Een download link naar het product wordt na de succesvolle betaling automatisch via email geleverd.<br/><br/>

                    1.4 Met de plaatsing van een bestelling en de betaling van een digitaal product gaat de koper een definitieve koopovereenkomst aan met Multiversum. De voorwaarden van deze overeenkomst zijn op Multiversum.snoozing.dev beschikbaar voordat en op het moment dat u een product bestelt. Tijdens het bestelproces dient u deze voorwaarden ook te accepteren.<br/><br/>

                    1.5 Een definitieve overeenkomst geeft de koper het niet-exclusieve en niet-overdraagbare recht voor het gebruik van de digitale producten. Bij de levering van het digitale product wordt een exemplaar van de toepasselijke Licentieovereenkomst gevoegd.<br/><br/>

                    1.6 Voor alle PayPal-transacties is het Privacybeleid van PayPal van toepassing welke hier te vinden is.<br/><br/>
                </Text>


                <Text fontSize='lg' mt='15px' fontWeight='bold'>
                    2 Intellectuele eigendomsrechten
                </Text>

                <Text fontSize='md'>
                    2.1 Alle intellectuele eigendomsrechten betreffende digitale producten, zowel in hun geheel als in onderdelen maar met uitzondering van die componenten waarop specifieke licentievoorwaarden van toepassing zijn, blijven onverminderd eigendom van Multiversum. U verplicht zich ertoe iedere handeling na te laten, die inbreuk doet op het intellectueel eigendomsrecht.<br/><br />

                    2.2 Multiversum garandeert dat de aan u geleverde digitale producten geen inbreuk maken op enig intellectueel eigendomsrecht van derden.<br/><br />
                </Text>

                <Text fontSize='lg' mt='15px' fontWeight='bold'>
                    3 Aansprakelijkheid en verantwoordelijkheid
                </Text>

                <Text fontSize='md'>
                    3.1 Multiversum is niet aansprakelijk voor schade die kan voortvloeien uit het gebruik van de betreffende producten.<br/><br/>

                    3.2 Correspondentie en/of levering vindt plaats via email en internet. U bent zelf verantwoordelijk voor het verstrekken van het juiste(email)adres aan Multiversum. Daarnaast bent u ook verantwoordelijk voor het juist instellen van uw PC en eventueel aanwezige programma’s zoals firewalls, spamfilters en virusscanners, zodat aan u verstuurde berichten en digitale producten kunnen worden ontvangen.<br/><br/>
                </Text>

                <Text fontSize='lg' mt='15px' fontWeight='bold'>
                    4 Copyright en niet toegestaan gebruik van downloads
                </Text>

                <Text fontSize='md'>
                    4.1 Op de digitale producten van Multiversum berust copyright. Het is daarom niet toegestaan de gekochte digitale producten te kopiëren en /of te verspreiden en/of commercieel te exploiteren.<br/><br/>

                    4.2 Het is niet toegestaan om “afgeleide werken” te maken door de downloads te modificeren en vervolgens te verspreiden of commercieel te exploiteren.<br/><br/>
                </Text>

                <Text fontSize='lg' mt='15px' fontWeight='bold'>
                    5 Bestelling annuleren
                </Text>

                <Text fontSize='md'>
                    5.1 Op digitale producten van Multiversum geldt geen recht van retour. Annuleren van reeds uitgevoerde en geleverde bestelling is om deze reden niet mogelijk.<br/><br/>
                </Text>

                <Text fontSize='lg' mt='15px' fontWeight='bold'>
                    6 Diversen
                </Text>

                <Text fontSize='md'>
                    6.1 Indien één of meer van de bepalingen van deze Voorwaarden in strijd is met enig toepasselijk recht, zal de betreffende bepaling komen te vervallen en zal deze worden vervangen door een door Multiversum vast te stellen nieuwe vergelijkbare bepaling.<br/><br/>

                    6.2 Op deze voorwaarden is uitsluitend Nederlands recht van toepassing.<br/><br/>

                    6.3 Alle geschillen tussen partijen zullen bij uitsluiting worden voorgelegd aan een daartoe bevoegde rechter in Nederland.<br/><br/>
                </Text>

                <Text as='i' mb='10px'>
                    Voor vragen kunt u via email contact met ons opnemen:<br/>
                    Multiversum | multiversum@snoozing.dev
                </Text>
            </Flex>

            <Footer />
        </Flex>
    </>
)

export default AVPage
