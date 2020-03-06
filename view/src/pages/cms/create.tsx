import Head from 'next/head'
import CMSHeader from "../../components/cms/header";
import { Flex, Input, Box, Text, Textarea, Checkbox, Stack, Button } from '@chakra-ui/core'

const CMSCreate = () => (
    <>
        <Head>
            <title>Admin Panel - Product toevoegen</title>
        </Head>

        <CMSHeader />

        <Flex width={['100%', '100%', '992px']} mx='auto' flexDirection="column">

            <Text fontSize="lg" w="100%" mb="0.75rem" fontWeight="bold">Product toevoegen</Text>

            <Flex w="100%">

               <Flex w="50%" flexDirection="column">
                   <Box w="100%" px="15px" mb="10px">
                       <Text mb="2px">Naam</Text>
                       <Input
                           placeholder=""
                           size="md"
                       />
                   </Box>

                   <Box w="100%" px="15px" mb="10px">
                       <Text mb="2px">Beschrijving</Text>
                       <Textarea />
                   </Box>

                   <Box w="50%" px="15px" mb="10px">
                       <Text mb="2px">Platform</Text>
                       <Stack spacing={2} isInline>
                           <Checkbox variantColor="green">
                               PC
                           </Checkbox>
                           <Checkbox variantColor="green">
                               Playstation 4
                           </Checkbox>
                           <Checkbox variantColor="green">
                               Standalone
                           </Checkbox>
                           <Checkbox variantColor="green">
                               Mobile
                           </Checkbox>
                       </Stack>
                   </Box>

                   <Box w="100%" px="15px" mb="10px">
                       <Text mb="2px">Included info</Text>
                       <Textarea />
                   </Box>

                   <Box w="100%" px="15px" mb="10px">
                       <Text mb="2px">Image</Text>
                       <Input
                           type="file"
                           size="md"
                       />
                   </Box>
               </Flex>

                <Flex w="50%" flexDirection="column">
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">Resolutie</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">Refrash Rate</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">Input Type</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">Colour</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">Earn</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">Earn</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">Brand</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">SKU</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                    <Box w="100%" px="15px" mb="10px">
                        <Text mb="2px">Brand</Text>
                        <Input
                            placeholder=""
                            size="md"
                        />
                    </Box>
                </Flex>

            </Flex>
            <Flex alignItems='end' w='100%'>
                <Button ml='auto' bg='secondary.500' color='white'>Versturen</Button>
            </Flex>

        </Flex>
    </>
)

export default CMSCreate
