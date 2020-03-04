import { FC } from 'react'
import { Flex, Tooltip,  Box, Image, Text, Tabs, TabList, TabPanels, Tab, TabPanel } from '@chakra-ui/core';
import { FaMobileAlt, FaDesktop, FaPlaystation } from 'react-icons/fa'



const ProductShow: FC = () => (
   <>
      <Flex
          wrap='wrap'
          width={['100%', '100%', '100%', '992px']}
          mx='auto'

      >

          <Box width={["100%", 4/12, 4/12, 4/12]}>
            <Image  src='https://unboundvr.nl/media/catalog/product/cache/1/thumbnail/600x600/e4d92e6aceaad517e7b5c12e0dc06587/h/y/hypersuit_htc-vive-pro_product.png' alt='Product logo' />
         </Box>

         <Box pl={["opx", "0px","3rem"]} width={["100%", 8/12, 8/12, 8/12]}>
             <Flex>
                 <Box w="50%">
                     <Text fontSize="xl" mb="30px" >Product titel</Text>
                 </Box>
                 <Flex w="50%">
                     <Box mx="10px">
                         <Tooltip aria-label="Mobiel" label="Mobiel" hasArrow placement="top">
                             <FaMobileAlt size="3rem" color="#F1C40F"/>
                         </Tooltip>
                     </Box>
                     <Box mx="10px">
                         <Tooltip aria-label="Mobiel" label="Mobiel" hasArrow placement="top">
                             <FaDesktop size="3rem" color="#1ABC9C"/>
                         </Tooltip>
                     </Box>
                     <Box mx="10px">
                         <Tooltip aria-label="Mobiel" label="Mobiel" hasArrow placement="top">
                            <FaPlaystation size="3rem" color="#F1C40F"/>
                         </Tooltip>
                     </Box>
                 </Flex>
             </Flex>
             <Tabs variant="soft-rounded" variantColor="main.500" isFitted>
                 <TabList>
                     <Tab>Specificaties</Tab>
                     <Tab>Plus/Min punten</Tab>
                 </TabList>

                 <TabPanels>
                     <TabPanel minHeight="4rem">
                         <Box mt="0.75rem">
                             <table>
                                 <tr>
                                     <td>Beschrijving</td>
                                     <td>Tekst om dingen te beschrijven.</td>
                                 </tr>
                                 <tr>
                                     <td>Platform</td>
                                     <td>PC</td>
                                 </tr>
                                 <tr>
                                     <td>Resolution</td>
                                     <td>2880x1600</td>
                                 </tr>
                                 <tr>
                                     <td>Refresh Rate</td>
                                     <td>90Hz</td>
                                 </tr>
                                 <tr>
                                     <td>Kleur</td>
                                     <td>Blauw</td>
                                 </tr>
                                 <tr>
                                     <td>Merk</td>
                                     <td>HTC</td>
                                 </tr>
                                 <tr>
                                     <td>EAN</td>
                                     <td>0192545934565</td>
                                 </tr>
                                 <tr>
                                     <td>SKU</td>
                                     <td>0192545934565</td>
                                 </tr>
                                 <tr>
                                     <td>Meegeleverd </td>
                                     <td>Camera, Gyroscoop, Koptelefoon, Microfoon, Verstelbare lenzen</td>
                                 </tr>
                             </table>
                         </Box>
                     </TabPanel>
                     <TabPanel minHeight="4rem">
                         <p>two!</p>
                     </TabPanel>
                 </TabPanels>
             </Tabs>

             <Flex justifyContent="end" >
                 <Text ml="auto" fontSize="xl" mr="6rem">€ 189,00</Text>
             </Flex>

         </Box>
      </Flex>
   </>
);

export default ProductShow
