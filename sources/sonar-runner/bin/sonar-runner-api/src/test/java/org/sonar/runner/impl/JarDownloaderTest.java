/*
 * SonarQube Runner - API
 * Copyright (C) 2011-2016 SonarSource SA
 * mailto:contact AT sonarsource DOT com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
package org.sonar.runner.impl;

import org.junit.Test;
import org.sonar.runner.cache.Logger;

import java.io.File;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;

import static org.fest.assertions.Assertions.assertThat;
import static org.mockito.Mockito.doReturn;
import static org.mockito.Mockito.mock;
import static org.mockito.Mockito.spy;

public class JarDownloaderTest {

  ServerConnection serverConnection = mock(ServerConnection.class);
  Properties props = new Properties();
  JarDownloader downloader = spy(new JarDownloader(serverConnection, mock(Logger.class), props));

  @Test
  public void should_download_jar_files() {
    doReturn(new ArrayList<File>()).when(downloader).download();
    List<File> jarFiles = downloader.download();
    assertThat(jarFiles).isNotNull();
  }
}
