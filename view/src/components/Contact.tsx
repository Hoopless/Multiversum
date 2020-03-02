import { FC } from 'react'
import { Flex, Box, Text, Input, Textarea, Button } from '@chakra-ui/core';

const Contact: FC = () => (
   <Box pb='10px'>
      <Flex width={['100%', '100%', '992px', '992px']} mx='auto'>

         <Box w={['100%', '100%', '50%', '50%' ]} pr='20px'>
            <Text fontSize='lg' w='100%' mb='5px'>Contact formulier</Text>

            <Box bg='white' w='100%' p='15px' px='20px'>
               <Box pb='15px'>
                  <Text fontSize='md' w='100%' fontWeight='semibold'>Naam</Text>
                  <Input bg='background' color='black' />
               </Box>


               <Box pb='15px'>
                  <Text fontSize='md' w='100%' fontWeight='semibold'>E-mail</Text>
                  <Input bg='background' color='black' />
               </Box>

              <Box pb='15px'>
                 <Text fontSize='md' w='100%' fontWeight='semibold'>Bericht</Text>
                 <Textarea bg='background' resize='none'  />
              </Box>

              <Flex alignItems='end' w='100%'>
                 <Button ml='auto' bg='secondary' color='white'>Versturen</Button>
              </Flex>

            </Box>
         </Box>

         <Box w={['100%', '100%', '50%', '50%' ]} pl='20px'>
            <Text fontSize='lg' w='100%'>Contact informatie</Text>
            <Box w='100%'>

            </Box>

            <Box >
               <Text fontSize='md' w='100%' fontWeight='semibold'>Bedrijfgegevens</Text>

               <Box fontSize='md'>
                  Multiversum<br />
                  1861 Jan Pieterszoon Coenstraat<br />
                  69217 Maasdriel<br />
                  Zeeland<br />
                  <br />

                  Routebeschrijving? Klik <a  href=''>hier</a> voor de routebeschrijving naar Multiversum.<br />
                  <br />

                  KvK: 12345678<br />
                  BTW-Nummer: NummerBTW<br />
               </Box>

            </Box>
         </Box>


      </Flex>
   </Box>
);

export default Contact
